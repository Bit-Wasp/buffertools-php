<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;
use Mdanter\Ecc\Math\GmpMathInterface;

abstract class AbstractSignedInt extends AbstractType implements SignedIntInterface
{
    /**
     * @param GmpMathInterface     $math
     * @param int                  $byteOrder
     */
    public function __construct(GmpMathInterface $math, int $byteOrder = ByteOrder::BE)
    {
        parent::__construct($math, $byteOrder);
    }

    /**
     * @param int|string $integer
     * @return string
     */
    public function writeBits($integer): string
    {
        return str_pad(
            gmp_strval(gmp_init($integer, 10), 2),
            $this->getBitSize(),
            '0',
            STR_PAD_LEFT
        );
    }

    /**
     * @param Parser $parser
     * @return int|string
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     * @throws \Exception
     */
    public function readBits(Parser $parser): string
    {
        $bitSize = $this->getBitSize();
        $byteSize = $bitSize / 8;

        $bytes = $parser->readBytes($byteSize);
        $bytes = $this->isBigEndian() ? $bytes : $bytes->flip();
        $chars = $bytes->getBinary();

        $offsetIndex = 0;
        $isNegative = (ord($chars[$offsetIndex]) & 0x80) != 0x00;
        $number = gmp_init(ord($chars[$offsetIndex++]) & 0x7F, 10);

        for ($i = 0; $i < $byteSize-1; $i++) {
            $number = gmp_or(gmp_mul($number, 0x100), ord($chars[$offsetIndex++]));
        }

        if ($isNegative) {
            $number = gmp_sub($number, gmp_pow(2, $bitSize - 1));
        }

        return gmp_strval($number, 10);
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::write()
     */
    public function write($integer): string
    {
        $bitSize = $this->getBitSize();
        if (gmp_sign($integer) < 0) {
            $integer = gmp_add($integer, (gmp_sub(gmp_pow(2, $bitSize), 1)));
            $integer = gmp_add($integer, 1);
        }

        $binary = Buffer::hex(str_pad(gmp_strval($integer, 16), $bitSize/4, '0', STR_PAD_LEFT), $bitSize/8);

        if (!$this->isBigEndian()) {
            $binary = $binary->flip();
        }

        return $binary->getBinary();
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::read()
     */
    public function read(Parser $binary): string
    {
        return $this->readBits($binary);
    }
}
