<?php

namespace BitWasp\Buffertools;

class Buffertools
{
    /**
     * Convert a decimal number into a VarInt Buffer
     *
     * @param  integer $decimal
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
     * @param  string|Buffer $bytes
     * @return string
     */
    public static function flipBytes($bytes)
    {
        if ($bytes instanceof Buffer) {
            $bytes = $bytes->getBinary();
        }

        return implode('', array_reverse(str_split($bytes, 1)));
    }

    /**
     * @param Buffer $buffer1
     * @param Buffer $buffer2
     * @param int    $size
     * @return Buffer
     */
    public static function concat(Buffer $buffer1, Buffer $buffer2, $size = null)
    {
        return new Buffer($buffer1->getBinary() . $buffer2->getBinary(), $size);
    }

    /**
     *  What if we don't have two buffers, or want to guard the types of the
     * sorting algorithm?
     *
     * The default behaviour should be, take a list of Buffers/SerializableInterfaces, and
     * sort their binary representation.
     *
     * If an anonymous function is provided, we completely defer the conversion of values to
     * Buffer to the $convertToBuffer callable.
     *
     * This is to allow anonymous functions which are responsible for converting the item to a buffer,
     * and which optionally type-hint the items in the array.
     *
     * @param array $items
     * @param callable $convertToBuffer
     * @return array
     */
    public static function sort(array $items, callable $convertToBuffer = null)
    {
        if (null == $convertToBuffer) {
            $convertToBuffer = function ($value) {
                if ($value instanceof Buffer) {
                    return $value;
                }
                if ($value instanceof SerializableInterface) {
                    return $value->getBuffer();
                }
                throw new \RuntimeException('Requested to sort unknown type');
            };
        }

        usort($items, function ($a, $b) use ($convertToBuffer) {
            $av = $convertToBuffer($a)->getBinary();
            $bv = $convertToBuffer($b)->getBinary();
            return $av == $bv ? 0 : $av > $bv ? 1 : -1;
        });

        return $items;
    }
}
