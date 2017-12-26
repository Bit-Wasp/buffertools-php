<?php

require "../vendor/autoload.php";

use BitWasp\Buffertools\Buffer;

// Binary data and ASCII can be passed directly to a Buffer
$binary = new Buffer('hello world');
echo $binary->getBinary() . PHP_EOL;
echo $binary->getHex() . PHP_EOL;

// BufferHex and BufferInt convert data to binary
$hex = Buffer::hex('68656c6c6f20776f726c64');
echo $binary->getBinary() . PHP_EOL;
echo $hex->getHex() . PHP_EOL;

// All Buffers expose getBinary(), getInt(), getHex()
$int = Buffer::int(65);
echo $int->getBinary() . PHP_EOL;
echo $int->getInt() . PHP_EOL;
echo $int->getHex() . PHP_EOL;
