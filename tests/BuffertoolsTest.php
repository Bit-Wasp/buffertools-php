<?php

namespace BitWasp\Buffertools;

use Mdanter\Ecc\EccFactory;

class BuffertoolsTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
    }

    public function setUp()
    {
    }

    public function testNumToVarInt()
    {
        // Should not prefix with anything. Just return chr($decimal);
        for ($i = 0; $i < 253; $i++) {
            $decimal = 1;
            $expected = chr($decimal);
            $val = Buffertools::numToVarInt($decimal)->getBinary();

            $this->assertSame($expected, $val);
        }
    }

    public function testNumToVarInt1LowerFailure()
    {
        // This decimal should NOT return a prefix
        $decimal  = 0xfc; // 252;
        $val = Buffertools::numToVarInt($decimal)->getBinary();
        $this->assertSame($val[0], chr(0xfc));
    }

    public function testNumToVarInt1Lowest()
    {
        // Decimal > 253 requires a prefix
        $decimal  = 0xfd;
        $expected = chr(0xfd).chr(0xfd).chr(0x00);
        $val = Buffertools::numToVarInt($decimal);//->getBinary();
        $this->assertSame($expected, $val->getBinary());
    }

    public function testNumToVarInt1Upper()
    {
        // This prefix is used up to 0xffff, because if we go higher,
        // the prefixes are no longer in agreement
        $decimal  = 0xffff;
        $expected = chr(0xfd) . chr(0xff) . chr(0xff);
        $val = Buffertools::numToVarInt($decimal)->getBinary();
        $this->assertSame($expected, $val);
    }

    public function testNumToVarInt2LowerFailure()
    {
        // We can check that numbers this low don't yield a 0xfe prefix
        $decimal    = 0xfffe;
        $expected   = chr(0xfe) . chr(0xfe) . chr(0xff);
        $val        = Buffertools::numToVarInt($decimal);

        $this->assertNotSame($expected, $val);
    }

    public function testNumToVarInt2Lowest()
    {
        // With this prefix, check that the lowest for this field IS prefictable.
        $decimal    = 0xffff0001;
        $expected   = chr(0xfe) . chr(0x01) . chr(0x00) . chr(0xff) . chr(0xff) ;
        $val        = Buffertools::numToVarInt($decimal);

        $this->assertSame($expected, $val->getBinary());
    }

    public function testNumToVarInt2Upper()
    {
        // Last number that will share 0xfe prefix: 2^32
        $decimal    = 0xffffffff;
        $expected   = chr(0xfe) . chr(0xff) . chr(0xff) . chr(0xff) . chr(0xff);
        $val        = Buffertools::numToVarInt($decimal);//->getBinary();

        $this->assertSame($expected, $val->getBinary());
    }

    /**
     * @expectedException \Exception
     */
    public function testNumToVarIntOutOfRange()
    {
        // Check that this is out of range (PHP's fault)
        $decimal  = EccFactory::getAdapter()->pow(2, 32) + 1;
        Buffertools::numToVarInt($decimal);
    }

    public function testFlipBytes()
    {
        $buffer = Buffer::hex('41');
        $string = $buffer->getBinary();
        $flip   = Buffertools::flipBytes($string);
        $this->assertSame($flip, $string);

        $buffer = Buffer::hex('4141');
        $string = $buffer->getBinary();
        $flip   = Buffertools::flipBytes($string);
        $this->assertSame($flip, $string);

        $buffer = Buffer::hex('4142');
        $string = $buffer->getBinary();
        $flip   = Buffertools::flipBytes($string);
        $this->assertSame($flip, chr(0x42) . chr(0x41));

        $buffer = Buffer::hex('0102030405060708');
        $string = $buffer->getBinary();
        $flip   = Buffertools::flipBytes($string);
        $this->assertSame($flip, chr(0x08) . chr(0x07) . chr(0x06) . chr(0x05) . chr(0x04) . chr(0x03) . chr(0x02) . chr(0x01));
    }
}
