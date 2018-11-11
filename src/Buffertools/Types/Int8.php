<?php

namespace BitWasp\Buffertools\Types;

class Int8 extends AbstractSignedInt
{
    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::getBitSize()
     */
    public function getBitSize()
    {
        return 8;
    }
}
