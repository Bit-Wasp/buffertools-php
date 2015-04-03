<?php

namespace BitWasp\Buffertools;

use Mdanter\Ecc\EccFactory;

class Buffer
{
    /**
     * @var int|double
     */
    private $size;

    /**
     * @var string
     */
    private $buffer;

    /**
     * @var \Mdanter\Ecc\MathAdapterInterface
     */
    private $math;

    /**
     * @param string $byteString
     * @param null|integer $byteSize
     * @throws \Exception
     */
    public function __construct($byteString = '', $byteSize = null)
    {
        $this->math = EccFactory::getAdapter();

        if (is_numeric($byteSize)) {
            // Check the integer doesn't overflow its supposed size
            if ($this->math->cmp(strlen($byteString), $byteSize) > 0) {
                throw new \Exception('Byte string exceeds maximum size');
            }
        }

        $this->size   = $byteSize;
        $this->buffer = $byteString;
    }

    /**
     * Return the max size of this buffer
     *
     * @return int|null
     */
    public function getMaxSize()
    {
        return $this->size;
    }

    /**
     * Create a new buffer from a hex string
     * @param $hex
     * @param integer $bitSize
     * @return Buffer
     * @throws \Exception
     */
    public static function hex($hex = '', $bitSize = null)
    {
        $buffer = pack("H*", $hex);
        return new self($buffer, $bitSize);
    }

    /**
     * @param integer $start
     * @param integer|null $end
     * @return Buffer
     * @throws \Exception
     */
    public function slice($start, $end = null)
    {
        $binary = $this->getBinary();
        $length = strlen($binary);
        if ($start > $length) {
            throw new \Exception('Start exceeds buffer length');
        }

        if ($end === null) {
            return new self(substr($binary, $start));
        }

        if ($end > $length) {
            throw new \Exception('Length exceeds buffer length');
        }

        $binary = substr($binary, $start, $end);
        return new self($binary);
    }

    /**
     * @param Buffer $buffer
     * @return $this
     */
    public function append(Buffer $buffer)
    {
        $this->buffer = $this->buffer . $buffer->getBinary();
        return $this;
    }

    /**
     * @param Buffer $buffer
     * @return $this
     */
    public function prepend(Buffer $buffer)
    {
        $this->buffer = $buffer->getBinary() . $this->buffer;
        return $this;
    }

    /**
     * Get the size of the buffer to be returned, depending on the $type
     *
     * @return int
     */
    public function getSize()
    {
        $size   = strlen($this->getBinary());
        return $size;
    }

    /**
     * @return string
     */
    public function getBinary()
    {
        return $this->buffer;
    }

    /**
     * @return string
     */
    public function getHex()
    {
        return bin2hex($this->getBinary());
    }

    /**
     * @return int|string
     */
    public function getInt()
    {
        return $this->math->hexDec($this->getHex());
    }

    /**
     * Print the contents of the buffer as a string
     *
     * @return string
     */
    public function __toString()
    {
        return unpack("H*", $this->buffer)[1];
    }
}
