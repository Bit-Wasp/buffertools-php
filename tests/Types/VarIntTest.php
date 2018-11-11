<?php

namespace BitWasp\Buffertools\Tests\Types;

use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Parser;
use BitWasp\Buffertools\Tests\BinaryTest;
use BitWasp\Buffertools\Types\VarInt;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Math\GmpMath;

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
     * @expectedExceptionMessage Unknown varint prefix
     */
    public function testSolveReadTooLong()
    {
        $math = EccFactory::getAdapter();
        $varint = new VarInt($math);
        $disallowed = $math->add($math->pow(gmp_init(2, 10), 64), gmp_init(1, 10));
        $varint->solveReadSize($disallowed);
    }

    public function getVarIntFixtures()
    {
        return [
            ["\x00", 0,],
            ["\xfc", 0xfc,],
            ["\xfd\xfd\x00", 0xfd,],
            ["\xfd\xff\xff", 0xffff,],
            ["\xfe\xff\xff\x7f\x7f", 0x7f7fffff,],
            ["\xfe\xff\xff\xff\xff", 0xffffffff,],
            ["\xff\xff\xff\xff\xff\xff\x00\x00\x00", 0xffffffffff,],
        ];
    }

    /**
     * @param string $bin
     * @param int|string $int
     * @dataProvider getVarIntFixtures
     */
    public function testVarIntRead($bin, $int)
    {
        $vi = new VarInt(new GmpMath());
        $this->assertEquals($int, $vi->read(new Parser(new Buffer($bin))));
    }

    /**
     * @param string $bin
     * @param int|string $int
     * @dataProvider getVarIntFixtures
     */
    public function testVarIntWrite($bin, $int)
    {
        $vi = new VarInt(new GmpMath());
        $this->assertEquals($bin, $vi->write($int));
    }
}
