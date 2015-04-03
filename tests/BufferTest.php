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
        $hex = '41414141';
        $bin = pack("H*", $hex);
        $this->buffer = Buffer::hex($hex);

        $this->assertSame(strlen($bin), $this->buffer->getSize());
    }

    public function testGetMaxSizeDefault()
    {
        $this->buffer = Buffer::hex('41414141');
        $this->assertNull($this->buffer->getMaxSize());
    }

    public function testGetMaxSize()
    {
        $maxSize = 4;
        $this->buffer = Buffer::hex('41414141', $maxSize);
        $this->assertNotNull($this->buffer->getMaxSize());
        $this->assertSame($this->buffer->getMaxSize(), $maxSize);
    }
}
