<?php

namespace BitWasp\Buffertools\Types;



class Uint128 extends AbstractIntType
{

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::getBitSize()
     */
    public function getBitSize()
    {
        return 128;
    }
}