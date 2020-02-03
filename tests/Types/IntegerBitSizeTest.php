<?php

namespace BitWasp\Buffertools\Tests\Types;

use BitWasp\Buffertools\Tests\BinaryTest;
use BitWasp\Buffertools\Types\Int128;
use BitWasp\Buffertools\Types\Int16;
use BitWasp\Buffertools\Types\Int256;
use BitWasp\Buffertools\Types\Int32;
use BitWasp\Buffertools\Types\Int64;
use BitWasp\Buffertools\Types\Int8;
use BitWasp\Buffertools\Types\SignedIntInterface;
use BitWasp\Buffertools\Types\Uint128;
use BitWasp\Buffertools\Types\Uint16;
use BitWasp\Buffertools\Types\Uint256;
use BitWasp\Buffertools\Types\Uint32;
use BitWasp\Buffertools\Types\Uint64;
use BitWasp\Buffertools\Types\Uint8;
use BitWasp\Buffertools\Types\UintInterface;

class IntegerBitSizeTest extends BinaryTest
{
    public function getClassAndBitSize()
    {
        return [
            [Uint8::class,8],
            [Uint16::class,16],
            [Uint32::class,32],
            [Uint64::class,64],
            [Uint128::class,128],
            [Uint256::class,256],
            [Int8::class,8],
            [Int16::class,16],
            [Int32::class,32],
            [Int64::class,64],
            [Int128::class,128],
            [Int256::class,256],
        ];
    }

    /**
     * @dataProvider getClassAndBitSize
     * @param string $integerClass
     * @param int $bitSize
     */
    public function testBitSize(string $integerClass, int $bitSize)
    {
        /** @var UintInterface|SignedIntInterface $integer */
        $integer = new $integerClass();
        $this->assertEquals($bitSize, $integer->getBitSize());
    }
}
