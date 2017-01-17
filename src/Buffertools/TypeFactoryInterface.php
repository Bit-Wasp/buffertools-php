<?php
/**
 * Created by PhpStorm.
 * User: tk
 * Date: 1/16/17
 * Time: 11:58 PM
 */
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

interface TypeFactoryInterface
{
    /**
     * Add a Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8();

    /**
     * Add a little-endian Uint8 serializer to the template
     *
     * @return Uint8
     */
    public function uint8le();

    /**
     * Add a Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16();

    /**
     * Add a little-endian Uint16 serializer to the template
     *
     * @return Uint16
     */
    public function uint16le();

    /**
     * Add a Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32();

    /**
     * Add a little-endian Uint32 serializer to the template
     *
     * @return Uint32
     */
    public function uint32le();

    /**
     * Add a Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64();

    /**
     * Add a little-endian Uint64 serializer to the template
     *
     * @return Uint64
     */
    public function uint64le();

    /**
     * Add a Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128();

    /**
     * Add a little-endian Uint128 serializer to the template
     *
     * @return Uint128
     */
    public function uint128le();

    /**
     * Add a Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256();

    /**
     * Add a little-endian Uint256 serializer to the template
     *
     * @return Uint256
     */
    public function uint256le();

    /**
     * Add a int8 serializer to the template
     *
     * @return Int8
     */
    public function int8();

    /**
     * Add a little-endian Int8 serializer to the template
     *
     * @return Int8
     */
    public function int8le();

    /**
     * Add a int16 serializer to the template
     *
     * @return Int16
     */
    public function int16();

    /**
     * Add a little-endian Int16 serializer to the template
     *
     * @return Int16
     */
    public function int16le();

    /**
     * Add a int32 serializer to the template
     *
     * @return Int32
     */
    public function int32();

    /**
     * Add a little-endian Int serializer to the template
     *
     * @return Int32
     */
    public function int32le();

    /**
     * Add a int64 serializer to the template
     *
     * @return Int64
     */
    public function int64();

    /**
     * Add a little-endian Int64 serializer to the template
     *
     * @return Int64
     */
    public function int64le();

    /**
     * Add a int128 serializer to the template
     *
     * @return Int128
     */
    public function int128();

    /**
     * Add a little-endian Int128 serializer to the template
     *
     * @return Int128
     */
    public function int128le();

    /**
     * Add a int256 serializer to the template
     *
     * @return Int256
     */
    public function int256();

    /**
     * Add a little-endian Int256 serializer to the template
     *
     * @return Int256
     */
    public function int256le();

    /**
     * Add a VarInt serializer to the template
     *
     * @return VarInt
     */
    public function varint();

    /**
     * Add a VarString serializer to the template
     *
     * @return VarString
     */
    public function varstring();

    /**
     * Add a byte string serializer to the template. This serializer requires a length to
     * pad/truncate to.
     *
     * @param  $length
     * @return ByteString
     */
    public function bytestring($length);

    /**
     * Add a little-endian byte string serializer to the template. This serializer requires
     * a length to pad/truncate to.
     *
     * @param  $length
     * @return ByteString
     */
    public function bytestringle($length);

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
    public function vector(callable $readHandler);
}
