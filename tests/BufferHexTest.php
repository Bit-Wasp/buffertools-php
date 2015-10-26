<?php

namespace BitWasp\Buffertools\Tests;

use BitWasp\Buffertools\BufferHex;

class BufferHexTest extends \PHPUnit_Framework_TestCase
{
    public function testHex()
    {
        $hex = 'a4e3fd9c';
        $buffer = new BufferHex($hex);
        $this->assertEquals($hex, $buffer->getHex());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidHex()
    {
        new BufferHex('abcdefg');
    }
}
