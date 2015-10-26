<?php

namespace BitWasp\Buffertools;


use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Math\MathAdapterInterface;

class BufferHex extends Buffer
{
    public function __construct($hexString = '', $byteSize = null, MathAdapterInterface $math = null)
    {
        $strlen = strlen($hexString);
        if ($strlen > 0 && $strlen % 2 == 0 && ctype_xdigit($hexString)) {
            throw new \InvalidArgumentException('BufferHex: non-hex character passed');
        }

        $math = $math ?: EccFactory::getAdapter();
        $binary = pack("H*", $hexString);
        parent::__construct($binary, $byteSize, $math);
    }
}