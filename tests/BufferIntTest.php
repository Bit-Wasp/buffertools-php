<?php

namespace BitWasp\Buffertools\Tests;


use BitWasp\Buffertools\BufferInt;

class BufferIntTest extends \PHPUnit_Framework_TestCase
{
    public function testInt()
    {
        $int = '12345678901234567890123456789012345678901234567890';
        $buffer = new BufferInt($int);
        $this->assertEquals($int, $buffer->getInt());
    }
}