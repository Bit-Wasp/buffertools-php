<?php

declare(strict_types=1);

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
    public function __construct(GmpMathInterface $math, int $byteOrder = ByteOrder::BE)
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
    public function getByteOrder(): int
    {
        return $this->byteOrder;
    }

    /**
     * @return bool
     */
    public function isBigEndian(): bool
    {
        return $this->getByteOrder() == ByteOrder::BE;
    }

    /**
     * @return GmpMathInterface
     */
    public function getMath(): GmpMathInterface
    {
        return $this->math;
    }

    /**
     * @param string $bitString
     * @return string
     * @throws \Exception
     */
    public function flipBits(string $bitString): string
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
