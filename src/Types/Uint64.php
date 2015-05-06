<?php

namespace BitWasp\Buffertools\Types;


class Uint64 extends AbstractIntType
{

    /**
     * {@inheritdoc}
     * @see \BitWasp\Binary\Types\TypeInterface::getBitSize()
     */
    public function getBitSize()
    {
        return 64;
    }
}