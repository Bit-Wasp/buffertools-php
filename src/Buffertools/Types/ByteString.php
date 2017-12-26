<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;

class ByteString extends AbstractType
{
    /**
     * @var int|string
     */
    private $length;

    /**
     * @param int           $length
     * @param int           $byteOrder
     */
    public function __construct(int $length, int $byteOrder = ByteOrder::BE)
    {
        $this->length = $length;
        parent::__construct($byteOrder);
    }

    /**
     * @param BufferInterface $string
     * @return string
     */
    public function writeBits(BufferInterface $string): string
    {
        $bits = str_pad(
            gmp_strval(gmp_init($string->getHex(), 16), 2),
            $this->length * 8,
            '0',
            STR_PAD_LEFT
        );

        return $bits;
    }

    /**
     * @param Buffer $string
     * @return string
     * @throws \Exception
     */
    public function write($string): string
    {
        if (!($string instanceof Buffer)) {
            throw new \InvalidArgumentException('FixedLengthString::write() must be passed a Buffer');
        }

        $bits = $this->isBigEndian()
            ? $this->writeBits($string)
            : $this->flipBits($this->writeBits($string));

        $hex = str_pad(
            gmp_strval(gmp_init($bits, 2), 16),
            $this->length * 2,
            '0',
            STR_PAD_LEFT
        );

        return pack("H*", $hex);
    }

    /**
     * @param BufferInterface $buffer
     * @return string
     */
    public function readBits(BufferInterface $buffer): string
    {
        return str_pad(
            gmp_strval(gmp_init($buffer->getHex(), 16), 2),
            $this->length * 8,
            '0',
            STR_PAD_LEFT
        );
    }

    /**
     * @param Parser $parser
     * @return BufferInterface
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function read(Parser $parser): BufferInterface
    {
        $bits = $this->readBits($parser->readBytes($this->length));
        if (!$this->isBigEndian()) {
            $bits = $this->flipBits($bits);
        }

        return Buffer::hex(
            str_pad(
                gmp_strval(gmp_init($bits, 2), 16),
                $this->length * 2,
                '0',
                STR_PAD_LEFT
            ),
            $this->length
        );
    }
}
