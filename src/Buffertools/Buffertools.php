<?php

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Exceptions\ParserOutOfRange;
use Mdanter\Ecc\EccFactory;

class Buffertools
{
    /**
     * Convert a decimal number into a VarInt Buffer
     *
     * @param integer $decimal
     * @return Buffer
     * @throws \Exception
     */
    public static function numToVarInt($decimal)
    {
        if ($decimal < 0xfd) {
            $bin = chr($decimal);
        } elseif ($decimal <= 0xffff) {
            // Uint16
            $bin = pack("Cv", 0xfd, $decimal);
        } elseif ($decimal <= 0xffffffff) {
            // Uint32
            $bin = pack("CV", 0xfe, $decimal);
        } else {
            // Todo, support for 64bit integers
            throw new \Exception('numToVarInt(): Integer too large');
        }

        return new Buffer($bin);
    }

    /**
     * Flip byte order of this binary string
     *
     * @param string $hex
     * @return string
     */
    public static function flipBytes($hex)
    {
        return implode('', array_reverse(str_split($hex, 1)));
    }

    /**
     * @param Buffer $buffer1
     * @param Buffer $buffer2
     * @param int $size
     * @return Buffer
     */
    public static function concat(Buffer $buffer1, Buffer $buffer2, $size = null)
    {
        return new Buffer($buffer1->getBinary() . $buffer2->getBinary(), $size);
    }
}
