<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Tests;

use \BitWasp\Buffertools\Buffer;
use \BitWasp\Buffertools\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParserEmpty()
    {
        $parser = new Parser();
        $this->assertInstanceOf(Parser::class, $parser);

        $this->assertSame(0, $parser->getPosition());
        $this->assertInstanceOf(Buffer::class, $parser->getBuffer());
        $this->assertEmpty($parser->getBuffer()->getHex());
    }

    public function testGetBuffer()
    {
        $buffer = Buffer::hex('41414141');

        $parser = new Parser($buffer);
        $this->assertSame($parser->getBuffer()->getBinary(), $buffer->getBinary());
    }

    public function testGetBufferEmptyNull()
    {
        $buffer = new Buffer();
        $parser = new Parser($buffer);
        $parserData = $parser->getBuffer()->getBinary();
        $bufferData = $buffer->getBinary();
        $this->assertSame($parserData, $bufferData);
    }

    public function testWriteBytes()
    {
        $bytes = Buffer::hex('41424344');

        $parser = new Parser();
        $parser->appendBuffer($bytes);
        $this->assertTrue($parser->getBuffer()->equals($bytes));
    }

    public function testWriteBytesFlip()
    {
        $bytes = Buffer::hex('41424344');
        $parser = new Parser();
        $parser->appendBuffer($bytes, true);

        $this->assertEquals('44434241', $parser->getBuffer()->getHex());
    }

    public function testWriteBytesPadded()
    {
        $parser = new Parser();
        $parser->appendBuffer(Buffer::hex('34'));
        $this->assertEquals("00000034", $parser->getBuffer()->getHex());
    }

    public function testWriteBytesFlipPadded()
    {
        $parser = new Parser();
        $parser->appendBuffer(Buffer::hex('34', 4), true);
        $this->assertEquals("34000000", $parser->getBuffer()->getHex());
    }

    public function testReadBytes()
    {
        $bytes = Buffer::hex('41424344');

        $parser = new Parser($bytes);
        $read = $parser->readBytes(4);
        $this->assertInstanceOf(Buffer::class, $read);

        $this->assertTrue($read->equals($bytes));
    }

    public function testReadBytesFlip()
    {
        $bytes = Buffer::hex('41424344');

        $parser = new Parser($bytes);
        $read = $parser->readBytes(4, true);
        $this->assertInstanceOf(Buffer::class, $read);

        $this->assertEquals($bytes->flip()->getHex(), $read->getHex());
    }

    /**
     * @expectedException \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     * @expectedExceptionMessage Could not parse string of required length (empty)
     */
    public function testReadBytesEmpty()
    {
        // Should return false because position is zero,
        // and length is zero.

        $parser = new Parser();
        $parser->readBytes(0);
    }
    /**
     * @expectedException \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     * @expectedExceptionMessage Could not parse string of required length (empty)
     */
    public function testReadBytesEndOfString()
    {
        $parser = new Parser(Buffer::hex('4041414142414141'));
        $bytes1 = $parser->readBytes(4);
        $bytes2 = $parser->readBytes(4);
        $this->assertSame($bytes1->getHex(), '40414141');
        $this->assertSame($bytes2->getHex(), '42414141');
        $parser->readBytes(1);
    }

    /**
     * @expectedException \Exception
     */
    public function testReadBytesBeyondLength()
    {
        $bytes = Buffer::hex('41424344');
        $parser = new Parser($bytes);
        $parser->readBytes(5);
    }
}
