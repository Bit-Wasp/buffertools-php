<?php

namespace BitWasp\Buffertools\Types;


class Uint16 extends AbstractIntType
{
    /**
     * {@inheritdoc}
     * @see \BitWasp\Binary\Types\TypeInterface::getBitSize()
     */
    public function getBitSize()
    {
        return 16;
    }

}