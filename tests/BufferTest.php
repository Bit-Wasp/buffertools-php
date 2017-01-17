<?php

namespace BitWasp\Buffertools\Tests\Util;

use \BitWasp\Buffertools\Buffer;
use Mdanter\Ecc\EccFactory;

class BufferTest extends \PHPUnit_Framework_TestCase
{
    public function testBufferDebug()
    {
        $buffer = new Buffer('AAAA', 4);
        $debug = $buffer->__debugInfo();
        $this->assertTrue(isset($debug['buffer']));
        $this->assertTrue(isset($debug['size']));

        $str = $debug['buffer'];
        $this->assertEquals('0x', substr($str, 0, 2));
        $this->assertEquals('41414141', substr($str, 2));
    }

    public function testCreateEmptyBuffer()
    {
        $buffer = new Buffer();
        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertEmpty($buffer->getBinary());
    }

    public function testCreateEmptyHexBuffer()
    {
        $buffer = Buffer::hex();
        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertEmpty($buffer->getBinary());
    }

    public function testCreateBuffer()
    {
        $hex = '80000000';
        $buffer = Buffer::hex($hex);
        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertNotEmpty($buffer->getBinary());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Byte string exceeds maximum size
     */
    public function testCreateMaxBufferExceeded()
    {
        $lim = 4;
        Buffer::hex('4141414111', $lim);
    }

    public function testCreateHexBuffer()
    {
        $hex = '41414141';
        $buffer = Buffer::hex($hex);
        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertNotEmpty($buffer->getBinary());
    }

    public function testPadding()
    {
        $buffer = Buffer::hex('41414141', 6);

        $this->assertEquals(4, $buffer->getInternalSize());
        $this->assertEquals(6, $buffer->getSize());
        $this->assertEquals("000041414141", $buffer->getHex());
    }

    public function testSerialize()
    {
        $hex = '41414141';
        $dec = EccFactory::getAdapter()->hexDec($hex);
        $bin = pack("H*", $hex);
        $buffer = Buffer::hex($hex);

        // Check Binary
        $retBinary = $buffer->getBinary();
        $this->assertSame($bin, $retBinary);

        // Check Hex
        $this->assertSame($hex, $buffer->getHex());

        // Check Decimal
        $this->assertSame($dec, $buffer->getInt());
        $this->assertInstanceOf(\GMP::class, $buffer->getGmp());
    }

    public function testGetSize()
    {
        $this->assertEquals(1, Buffer::hex('41')->getSize());
        $this->assertEquals(4, Buffer::hex('41414141')->getSize());
        $this->assertEquals(4, Buffer::hex('41', 4)->getSize());
    }

    public function IntVectors()
    {
        $math = EccFactory::getAdapter();

        return array(
            array('1',  1,      '01', $math),
            array('1',  null,   '01', $math),
            array('20', 1,      '14', $math)
        );
    }

    /**
     * @dataProvider IntVectors
     */
    public function testIntConstruct($int, $size, $expectedHex, $math)
    {
        $buffer = Buffer::int($int, $size, $math);
        $this->assertEquals($expectedHex, $buffer->getHex());
    }

    public function testSlice()
    {
        $a = Buffer::hex("11000011");
        $this->assertEquals("1100", $a->slice(0, 2)->getHex());
        $this->assertEquals("0011", $a->slice(2, 4)->getHex());

        $b = Buffer::hex("00111100");
        $this->assertEquals("0011", $b->slice(0, 2)->getHex());
        $this->assertEquals("1100", $b->slice(2, 4)->getHex());

        $c = Buffer::hex("111100", 4);
        $this->assertEquals("0011", $c->slice(0, 2)->getHex());
        $this->assertEquals("1100", $c->slice(2, 4)->getHex());
    }

    public function testEquals()
    {
        $first = Buffer::hex('ab');
        $second = Buffer::hex('ab');
        $firstExtraLong = Buffer::hex('ab', 10);
        $firstShort = new Buffer('', 0);
        $this->assertTrue($first->equals($second));
        $this->assertFalse($first->equals($firstExtraLong));
        $this->assertFalse($first->equals($firstExtraLong));
        $this->assertFalse($first->equals($firstShort));
    }
}
