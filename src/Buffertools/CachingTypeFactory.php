<?php

declare(strict_types=1);

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
    public function uint8(): Uint8
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint8(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8le(): Uint8
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint8le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16(): Uint16
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint16(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16le(): Uint16
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint16le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32(): Uint32
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint32(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32le(): Uint32
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint32le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64(): Uint64
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint64(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64le(): Uint64
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint64le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128(): Uint128
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint128(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128le(): Uint128
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint128le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256(): Uint256
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint256(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256le(): Uint256
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::uint256le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int8 serializer to the template
     *
     * @return Int8
     */
    public function int8(): Int8
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int8(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int8 serializer to the template
     *
     * @return Int8
     */
    public function int8le(): Int8
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int8le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int16 serializer to the template
     *
     * @return Int16
     */
    public function int16(): Int16
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int16(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int16 serializer to the template
     *
     * @return Int16
     */
    public function int16le(): Int16
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int16le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int32 serializer to the template
     *
     * @return Int32
     */
    public function int32(): Int32
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int32(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int serializer to the template
     *
     * @return Int32
     */
    public function int32le(): Int32
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int32le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int64 serializer to the template
     *
     * @return Int64
     */
    public function int64(): Int64
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int64(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int64 serializer to the template
     *
     * @return Int64
     */
    public function int64le(): Int64
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int64le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int128 serializer to the template
     *
     * @return Int128
     */
    public function int128(): Int128
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int128(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int128 serializer to the template
     *
     * @return Int128
     */
    public function int128le(): Int128
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int128le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a int256 serializer to the template
     *
     * @return Int256
     */
    public function int256(): Int256
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int256(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a little-endian Int256 serializer to the template
     *
     * @return Int256
     */
    public function int256le(): Int256
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::int256le(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a VarInt serializer to the template
     *
     * @return VarInt
     */
    public function varint(): VarInt
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::varint(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a VarString serializer to the template
     *
     * @return VarString
     */
    public function varstring(): VarString
    {
        if (!isset($this->cache[__FUNCTION__])) {
            $this->cache[__FUNCTION__] = parent::varstring(...func_get_args());
        }
        return $this->cache[__FUNCTION__];
    }

    /**
     * Add a byte string serializer to the template. This serializer requires a length to
     * pad/truncate to.
     *
     * @param  int $length
     * @return ByteString
     */
    public function bytestring(int $length): ByteString
    {
        if (!isset($this->cache[__FUNCTION__ . $length])) {
            $this->cache[__FUNCTION__ . $length] = parent::bytestring(...func_get_args());
        }
        return $this->cache[__FUNCTION__ . $length];
    }

    /**
     * Add a little-endian byte string serializer to the template. This serializer requires
     * a length to pad/truncate to.
     *
     * @param  int $length
     * @return ByteString
     */
    public function bytestringle(int $length): ByteString
    {
        if (!isset($this->cache[__FUNCTION__ . $length])) {
            $this->cache[__FUNCTION__ . $length] = parent::bytestringle(...func_get_args());
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
    public function vector(callable $readHandler): Vector
    {
        return parent::vector($readHandler);
    }
}
