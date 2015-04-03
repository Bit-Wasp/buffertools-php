<?php

namespace BitWasp\Buffertools\Tests\Util;

use \BitWasp\Buffertools\Buffer;
use Mdanter\Ecc\EccFactory;

class BufferTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Buffer
     */
    protected $buffer;

    /**
     * @var string
     */
    protected $bufferType;

    public function __construct()
    {
        $this->bufferType = 'BitWasp\Buffertools\Buffer';
    }

    public function setUp()
    {
        $this->buffer = null;
    }

    public function testCreateEmptyBuffer()
    {
        $this->buffer = new Buffer();
        $this->assertInstanceOf($this->bufferType, $this->buffer);
        $this->assertEmpty($this->buffer->getBinary());
    }

    public function testCreateEmptyHexBuffer()
    {
        $this->buffer = Buffer::hex();
        $this->assertInstanceOf($this->bufferType, $this->buffer);
        $this->assertEmpty($this->buffer->getBinary());
    }

    public function testCreateBuffer()
    {
        $hex = '80000000';
        $this->buffer = Buffer::hex($hex);
        $this->assertInstanceOf($this->bufferType, $this->buffer);
        $this->assertNotEmpty($this->buffer->getBinary());
    }

    public function testCreateMaxBuffer()
    {
        $deci = 4294967295;
        $hex = EccFactory::getAdapter()->decHex($deci);
        $lim = 32;
        $this->buffer = Buffer::hex($hex, $lim);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Byte string exceeds maximum size
     */
    public function testCreateMaxBufferExceeded()
    {
        $lim = 4;
        $this->buffer = Buffer::hex('414141411', $lim);
    }

    public function testCreateHexBuffer()
    {
        $hex = '41414141';
        $this->buffer = Buffer::hex($hex);
        $this->assertInstanceOf($this->bufferType, $this->buffer);
        $this->assertNotEmpty($this->buffer->getBinary());
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
        $this->buffer = Buffer::hex($hex);

        // Check Binary
        $retBinary = $this->buffer->getBinary();
        $this->assertSame($bin, $retBinary);

        // Check Hex
        $this->assertSame($hex, $this->buffer->getHex());

        // Check Decimal
        $this->assertSame($dec, $this->buffer->getInt());
    }

    public function testGetSize()
    {
        $this->assertEquals(1, Buffer::hex('41')->getSize());
        $this->assertEquals(4, Buffer::hex('41414141')->getSize());
        $this->assertEquals(4, Buffer::hex('41', 4)->getSize());
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
}
