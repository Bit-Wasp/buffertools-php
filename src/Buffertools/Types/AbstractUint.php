<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;
use Mdanter\Ecc\Math\GmpMathInterface;

abstract class AbstractUint extends AbstractType implements UintInterface
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
     * @param $integer
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
        $bits = str_pad(
            gmp_strval(gmp_init($parser->readBytes($bitSize / 8)->getHex(), 16), 2),
            $bitSize,
            '0',
            STR_PAD_LEFT
        );

        $finalBits = $this->isBigEndian()
            ? $bits
            : $this->flipBits($bits);

        $integer = gmp_strval(gmp_init($finalBits, 2), 10);

        return $integer;
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::write()
     */
    public function write($integer): string
    {
        return pack(
            "H*",
            str_pad(
                gmp_strval(
                    gmp_init(
                        $this->isBigEndian()
                        ? $this->writeBits($integer)
                        : $this->flipBits($this->writeBits($integer)),
                        2
                    ),
                    16
                ),
                $this->getBitSize()/4,
                '0',
                STR_PAD_LEFT
            )
        );
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
