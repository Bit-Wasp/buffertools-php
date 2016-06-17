<?php

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\ByteOrder;
use Mdanter\Ecc\Math\GmpMathInterface;

abstract class AbstractType implements TypeInterface
{
    /**
     * @var GmpMathInterface
     */
    private $math;

    /**
     * @var
     */
    private $byteOrder;

    /**
     * @param GmpMathInterface     $math
     * @param int                  $byteOrder
     */
    public function __construct(GmpMathInterface $math, $byteOrder = ByteOrder::BE)
    {
        if (false === in_array($byteOrder, [ByteOrder::BE, ByteOrder::LE])) {
            throw new \InvalidArgumentException('Must pass valid flag for endianness');
        }

        $this->math = $math;
        $this->byteOrder = $byteOrder;
    }

    /**
     * @return int
     */
    public function getByteOrder()
    {
        return $this->byteOrder;
    }

    /**
     * @return bool
     */
    public function isBigEndian()
    {
        return $this->getByteOrder() == ByteOrder::BE;
    }

    /**
     * @return GmpMathInterface
     */
    public function getMath()
    {
        return $this->math;
    }

    /**
     * @param $bitString
     * @return string
     * @throws \Exception
     */
    public function flipBits($bitString)
    {
        $length = strlen($bitString);

        if ($length % 8 !== 0) {
            throw new \Exception('Bit string length must be a multiple of 8');
        }

        $newString = '';
        for ($i = $length; $i >= 0; $i -= 8) {
            $newString .= substr($bitString, $i, 8);
        }

        return $newString;
    }
}
