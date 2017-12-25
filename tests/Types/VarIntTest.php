<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Tests\Types;

use BitWasp\Buffertools\Tests\BinaryTest;
use BitWasp\Buffertools\Types\VarInt;

class VarIntTest extends BinaryTest
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Integer too large, exceeds 64 bit
     */
    public function testSolveWriteTooLong()
    {
        $varint = new VarInt();
        $disallowed = gmp_add(gmp_pow(gmp_init(2, 10), 64), gmp_init(1, 10));
        $varint->solveWriteSize($disallowed);
    }
}
