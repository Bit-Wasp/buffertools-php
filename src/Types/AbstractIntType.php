<?php

namespace BitWasp\Buffertools\Types;


use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;
use Mdanter\Ecc\Math\MathAdapterInterface;

abstract class AbstractIntType extends AbstractType implements IntTypeInterface
{
    /**
     * @param MathAdapterInterface $math
     * @param int                  $byteOrder
     */
    public function __construct(MathAdapterInterface $math, $byteOrder = ByteOrder::BigEndian)
    {
        parent::__construct($math, $byteOrder);
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Binary\Types\TypeInterface::writeBits()
     */
    public function writeBits($integer)
    {
        $math = $this->getMath();

        return str_pad(
            $math->baseConvert($integer, 10, 2),
            $this->getBitSize(),
            '0',
            STR_PAD_LEFT
        );
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Binary\Types\TypeInterface::readBits()
     */
    public function readBits(Parser & $string)
    {
        $math = $this->getMath();
        $bitSize = $this->getBitSize();
        $bits = str_pad(
            $math->baseConvert($string->readBytes($bitSize / 8)->getHex(), 16, 2),
            $bitSize,
            '0',
            STR_PAD_LEFT
        );

        $integer = $math->baseConvert(
            $this->isBigEndian()
            ? $bits
            : $this->flipBits($bits),
            2,
            10
        );

        return $integer;
    }

    /**
     * @param $integer
     * @return string
     */
    public function write($integer)
    {
        return pack(
            "H*",
            str_pad(
                $this->getMath()->baseConvert(
                    $this->isBigEndian()
                    ? $this->writeBits($integer)
                    : $this->flipBits($this->writeBits($integer)),
                    2,
                    16
                ),
                $this->getBitSize()/4,
                '0',
                STR_PAD_LEFT
            )
        );
    }

    /**
     * @param $binary
     * @return int|string
     */
    public function read(Parser & $binary)
    {
        return $this->readBits($binary);
    }
}