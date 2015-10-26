<?php

namespace BitWasp\Buffertools;


use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Math\MathAdapterInterface;

class BufferInt extends BufferHex
{
    /**
     * @param string $integer
     * @param integer|null $byteSize
     * @param MathAdapterInterface|null $math
     */
    public function __construct($integer, $byteSize = null, MathAdapterInterface $math = null)
    {
        $math = $math ?: EccFactory::getAdapter();
        $hex = $math->decHex($integer);

        parent::__construct($hex, $byteSize, $math);
    }
}