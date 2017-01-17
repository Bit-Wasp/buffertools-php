<?php

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Types\ByteString;
use BitWasp\Buffertools\Types\Int128;
use BitWasp\Buffertools\Types\Int16;
use BitWasp\Buffertools\Types\Int256;
use BitWasp\Buffertools\Types\Int32;
use BitWasp\Buffertools\Types\Int64;
use BitWasp\Buffertools\Types\Int8;
use BitWasp\Buffertools\Types\Uint128;
use BitWasp\Buffertools\Types\Uint16;
use BitWasp\Buffertools\Types\Uint256;
use BitWasp\Buffertools\Types\Uint32;
use BitWasp\Buffertools\Types\Uint64;
use BitWasp\Buffertools\Types\Uint8;
use BitWasp\Buffertools\Types\VarInt;
use BitWasp\Buffertools\Types\VarString;
use BitWasp\Buffertools\Types\Vector;

class CachingTypeFactory extends TypeFactory
{
    protected $cache = [];

    /**
     * Add a Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int8 serializer to the template
     *
     * @return Int8
     */
    public function int8()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int8 serializer to the template
     *
     * @return Int8
     */
    public function int8le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int16 serializer to the template
     *
     * @return Int16
     */
    public function int16()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int16 serializer to the template
     *
     * @return Int16
     */
    public function int16le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int32 serializer to the template
     *
     * @return Int32
     */
    public function int32()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int serializer to the template
     *
     * @return Int32
     */
    public function int32le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int64 serializer to the template
     *
     * @return Int64
     */
    public function int64()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int64 serializer to the template
     *
     * @return Int64
     */
    public function int64le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int128 serializer to the template
     *
     * @return Int128
     */
    public function int128()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int128 serializer to the template
     *
     * @return Int128
     */
    public function int128le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int256 serializer to the template
     *
     * @return Int256
     */
    public function int256()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int256 serializer to the template
     *
     * @return Int256
     */
    public function int256le()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a VarInt serializer to the template
     *
     * @return VarInt
     */
    public function varint()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a VarString serializer to the template
     *
     * @return VarString
     */
    public function varstring()
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a byte string serializer to the template. This serializer requires a length to
     * pad/truncate to.
     *
     * @param  $length
     * @return ByteString
     */
    public function bytestring($length)
    {
        if (!isset($this->cache[__FUNCTION__ . $length])) {
            $this->cache[__FUNCTION__ . $length] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__ . $length];
    }

    /**
     * Add a little-endian byte string serializer to the template. This serializer requires
     * a length to pad/truncate to.
     *
     * @param  $length
     * @return ByteString
     */
    public function bytestringle($length)
    {
        if (!isset($this->cache[__FUNCTION__ . $length])) {
            $this->cache[__FUNCTION__ . $length] = call_user_func_array(['parent', __FUNCTION__], func_get_args());
        }
        return $this->cache[__FUNCTION__ . $length];
    }

    /**
     * Add a vector serializer to the template. A $readHandler must be provided if the
     * template will be used to deserialize a vector, since it's contents are not known.
     *
     * The $readHandler should operate on the parser reference, reading the bytes for each
     * item in the collection.
     *
     * @param  callable $readHandler
     * @return Vector
     */
    public function vector(callable $readHandler)
    {
        return parent::vector($readHandler);
    }
}
