<?php

namespace BitWasp\Buffertools\Tests;

use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Types\Uint64;
use BitWasp\Buffertools\Template;
use BitWasp\Buffertools\Types\VarInt;
use BitWasp\Buffertools\Types\VarString;
use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Parser;

class TemplateTest extends BinaryTest
{
    public function testTemplate()
    {
        $template = new Template();
        $this->assertEmpty($template->getItems());
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage No items in template
     */
    public function testTemplateEmptyParse()
    {
        $template = new Template();
        $parser = new Parser('010203040a0b0c0d');
        $template->parse($parser);
    }

    public function testAddItemToTemplate()
    {
        $math = \Mdanter\Ecc\EccFactory::getAdapter();
        $item = new Uint64($math);
        $template = new Template();

        $this->assertEmpty($template->getItems());
        $this->assertEquals(0, $template->count());
        $template->addItem($item);

        $items = $template->getItems();
        $this->assertEquals(1, count($template));

        $this->assertEquals($item, $items[0]);
    }

    public function testAddThroughConstructor()
    {
        $math = \Mdanter\Ecc\EccFactory::getAdapter();
        $item = new Uint64($math);
        $template = new Template([$item]);

        $items = $template->getItems();
        $this->assertEquals(1, count($items));
        $this->assertEquals($item, $items[0]);
    }

    public function testParse()
    {
        $value = '50c3000000000000';
        $varint = '19';
        $script = '76a914d04b020dab70a7dd7055db3bbc70d27c1b25a99c88ac';

        $buffer = Buffer::hex($value . $varint . $script);
        $parser = new Parser($buffer);

        $math = \Mdanter\Ecc\EccFactory::getAdapter();
        $uint64le = new Uint64($math, ByteOrder::LittleEndian);
        $varstring = new VarString(new VarInt($math));
        $template = new Template([$uint64le, $varstring]);

        list ($foundValue, $foundScript) = $template->parse($parser);

        $secondParser = new Parser($buffer);
        $secondValue = $secondParser->readBytes(8, true)->getInt();
        $secondScript = $secondParser->getVarString();

        $this->assertInternalType('string', $foundValue);
        $this->assertInstanceOf('BitWasp\Buffertools\Buffer', $secondScript);

        $this->assertEquals(50000, $secondValue);
        $this->assertEquals(50000, $foundValue);

        $this->assertEquals($script, $secondScript->getHex());
        $this->assertEquals($script, $foundScript->getHex());
    }

    public function testWrite()
    {
        $value = '50c3000000000000';
        $varint = '19';
        $script = '76a914d04b020dab70a7dd7055db3bbc70d27c1b25a99c88ac';
        $hex = $value . $varint . $script;

        $math = \Mdanter\Ecc\EccFactory::getAdapter();
        $uint64le = new Uint64($math, ByteOrder::LittleEndian);
        $varstring = new VarString(new VarInt($math));
        $template = new Template([$uint64le, $varstring]);

        $binary = $template->write([50000, Buffer::hex($script)]);
        $this->assertEquals(pack("H*", $hex), $binary);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Number of items must match template
     */
    public function testWriteIncomplete()
    {
        $math = \Mdanter\Ecc\EccFactory::getAdapter();
        $uint64le = new Uint64($math, ByteOrder::LittleEndian);
        $varstring = new VarString(new VarInt($math));
        $template = new Template([$uint64le, $varstring]);

        $template->write([50000]);
    }
}