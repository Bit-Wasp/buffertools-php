<?php

namespace BitWasp\Buffertools;

class ByteOrder
{
    /**
     * Little endian means bytes must be flipped
     */
    const LittleEndian = 0;

    /**
     * Assuming machine byte order?
     */
    const BigEndian = 1;
}
