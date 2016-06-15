<?php

namespace BitWasp\Buffertools\Tests\Types;

use BitWasp\Buffertools\Tests\BinaryTest;
use BitWasp\Buffertools\Types\VarInt;
use Mdanter\Ecc\EccFactory;

class VarIntTest extends BinaryTest
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Integer too large, exceeds 64 bit
     */
    public function testSolveWriteTooLong()
    {
        $math = EccFactory::getAdapter();
        $varint = new VarInt($math);
        $disallowed = $math->add($math->pow(gmp_init(2, 10), 64), gmp_init(1, 10));
        $varint->solveWriteSize($disallowed);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Integer too large, exceeds 64 bit
     */
    public function testSolveReadTooLong()
    {
        $math = EccFactory::getAdapter();
        $varint = new VarInt($math);
        $disallowed = $math->add($math->pow(gmp_init(2, 10), 64), gmp_init(1, 10));
        $varint->solveReadSize($disallowed);
    }
}
