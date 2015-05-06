<?php

namespace BitWasp\Buffertools;


use BitWasp\Buffertools\Types\Vector;
use BitWasp\Buffertools\Types\Uint8;
use BitWasp\Buffertools\Types\Uint16;
use BitWasp\Buffertools\Types\Uint32;
use BitWasp\Buffertools\Types\Uint64;
use BitWasp\Buffertools\Types\Uint128;
use BitWasp\Buffertools\Types\Uint256;
use BitWasp\Buffertools\Types\VarInt;
use BitWasp\Buffertools\Types\VarString;
use Mdanter\Ecc\Math\MathAdapterInterface;

class TemplateFactory
{
    /**
     * @var MathAdapterInterface
     */
    private $math;

    /**
     * @var \BitWasp\Buffertools\Template
     */
    private $template;

    /**
     * @param MathAdapterInterface $math
     */
    public function __construct(MathAdapterInterface $math, Template $template = null)
    {
        $this->math = $math;
        $this->template = $template ?: new Template();
    }

    /**
     * @return Template|Types\TypeInterface[]
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @return $this
     */
    public function uint8()
    {
        $this->template->addItem(new Uint8($this->math, ByteOrder::BigEndian));

        return $this;
    }

    /**
     * @return $this
     */
    public function uint8le()
    {
        $this->template->addItem(new Uint8($this->math, ByteOrder::LittleEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint16()
    {
        $this->template->addItem(new Uint16($this->math, ByteOrder::BigEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint16le()
    {
        $this->template->addItem(new Uint16($this->math, ByteOrder::LittleEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint32()
    {
        $this->template->addItem(new Uint32($this->math, ByteOrder::BigEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint32le()
    {
        $this->template->addItem(new Uint32($this->math, ByteOrder::LittleEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint64()
    {
        $this->template->addItem(new Uint64($this->math, ByteOrder::BigEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint64le()
    {
        $this->template->addItem(new Uint64($this->math, ByteOrder::LittleEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint128()
    {
        $this->template->addItem(new Uint128($this->math, ByteOrder::BigEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint128le()
    {
        $this->template->addItem(new Uint128($this->math, ByteOrder::LittleEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint256()
    {
        $this->template->addItem(new Uint256($this->math, ByteOrder::BigEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function uint256le()
    {
        $this->template->addItem(new Uint256($this->math, ByteOrder::LittleEndian));
        return $this;
    }

    /**
     * @return $this
     */
    public function varint()
    {
        $this->template->addItem(new VarInt($this->math));
        return $this;
    }

    /**
     * @return $this
     */
    public function varstring()
    {
        $this->template->addItem(new VarString(new VarInt($this->math), ByteOrder::BigEndian));
        return $this;
    }

    /**
     * @param callable $readHandler
     * @return $this
     */
    public function vector(callable $readHandler)
    {
        $this->template->addItem(new Vector(new VarInt($this->math), $readHandler));
        return $this;
    }
}