<?php

namespace BitWasp\Buffertools\Types;


interface IntTypeInterface extends TypeInterface
{
    /**
     * @return int
     */
    public function getBitSize();
}