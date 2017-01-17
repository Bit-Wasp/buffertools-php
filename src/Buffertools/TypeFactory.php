<?php

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Types\ByteString;
use BitWasp\Buffertools\Types\Int128;
use BitWasp\Buffertools\Types\Int16;
use BitWasp\Buffertools\Types\Int256;
use BitWasp\Buffertools\Types\Int32;
use BitWasp\Buffertools\Types\Int64;
use BitWasp\Buffertools\Types\Int8;
use BitWasp\Buffertools\Types\Uint8;
use BitWasp\Buffertools\Types\Uint16;
use BitWasp\Buffertools\Types\Uint32;
use BitWasp\Buffertools\Types\Uint64;
use BitWasp\Buffertools\Types\Uint128;
use BitWasp\Buffertools\Types\Uint256;
use BitWasp\Buffertools\Types\VarInt;
use BitWasp\Buffertools\Types\VarString;
use BitWasp\Buffertools\Types\Vector;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Math\GmpMathInterface;

class TypeFactory implements TypeFactoryInterface
{
    /**
     * @var GmpMathInterface
     */
    private $math;

    /**
     * @param GmpMathInterface $math
     */
    public function __construct(GmpMathInterface $math = null)
    {
        $this->math = $math ?: EccFactory::getAdapter();
    }

    /**
     * Add a Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8()
    {
        return new Uint8($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8le()
    {
        return new Uint8($this->math, ByteOrder::LE);
    }

    /**
     * Add a Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16()
    {
        return new Uint16($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16le()
    {
        return new Uint16($this->math, ByteOrder::LE);
    }

    /**
     * Add a Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32()
    {
        return new Uint32($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32le()
    {
        return new Uint32($this->math, ByteOrder::LE);
    }

    /**
     * Add a Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64()
    {
        return new Uint64($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64le()
    {
        return new Uint64($this->math, ByteOrder::LE);
    }

    /**
     * Add a Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128()
    {
        return new Uint128($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128le()
    {
        return new Uint128($this->math, ByteOrder::LE);
    }

    /**
     * Add a Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256()
    {
        return new Uint256($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256le()
    {
        return new Uint256($this->math, ByteOrder::LE);
    }

    /**
     * Add a int8 serializer to the template
     *
     * @return Int8
     */
    public function int8()
    {
        return new Int8($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Int8 serializer to the template
     *
     * @return Int8
     */
    public function int8le()
    {
        return new Int8($this->math, ByteOrder::LE);
    }

    /**
     * Add a int16 serializer to the template
     *
     * @return Int16
     */
    public function int16()
    {
        return new Int16($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Int16 serializer to the template
     *
     * @return Int16
     */
    public function int16le()
    {
        return new Int16($this->math, ByteOrder::LE);
    }

    /**
     * Add a int32 serializer to the template
     *
     * @return Int32
     */
    public function int32()
    {
        return new Int32($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Int serializer to the template
     *
     * @return Int32
     */
    public function int32le()
    {
        return new Int32($this->math, ByteOrder::LE);
    }

    /**
     * Add a int64 serializer to the template
     *
     * @return Int64
     */
    public function int64()
    {
        return new Int64($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Int64 serializer to the template
     *
     * @return Int64
     */
    public function int64le()
    {
        return new Int64($this->math, ByteOrder::LE);
    }

    /**
     * Add a int128 serializer to the template
     *
     * @return Int128
     */
    public function int128()
    {
        return new Int128($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Int128 serializer to the template
     *
     * @return Int128
     */
    public function int128le()
    {
        return new Int128($this->math, ByteOrder::LE);
    }

    /**
     * Add a int256 serializer to the template
     *
     * @return Int256
     */
    public function int256()
    {
        return new Int256($this->math, ByteOrder::BE);
    }

    /**
     * Add a little-endian Int256 serializer to the template
     *
     * @return Int256
     */
    public function int256le()
    {
        return new Int256($this->math, ByteOrder::LE);
    }

    /**
     * Add a VarInt serializer to the template
     *
     * @return VarInt
     */
    public function varint()
    {
        return new VarInt($this->math);
    }

    /**
     * Add a VarString serializer to the template
     *
     * @return VarString
     */
    public function varstring()
    {
        return new VarString(new VarInt($this->math), ByteOrder::BE);
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
        return new ByteString($this->math, $length, ByteOrder::BE);
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
        return new ByteString($this->math, $length, ByteOrder::LE);
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
        return new Vector($this->varint(), $readHandler);
    }
}
