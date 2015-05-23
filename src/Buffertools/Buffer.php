<?php

namespace BitWasp\Buffertools;

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\MathAdapterInterface;

class Buffer
{
    /**
     * @var int|string
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
     * @param string               $byteString
     * @param null|integer         $byteSize
     * @param MathAdapterInterface $math
     * @throws \Exception
     */
    public function __construct($byteString = '', $byteSize = null, MathAdapterInterface $math = null)
    {
        $this->math = $math ?: EccFactory::getAdapter();

        if ($byteSize !== null) {
            // Check the integer doesn't overflow its supposed size
            if ($this->math->cmp(strlen($byteString), $byteSize) > 0) {
                throw new \Exception('Byte string exceeds maximum size');
            }
        } else {
            $byteSize = strlen($byteString);
        }

        $this->size   = $byteSize;
        $this->buffer = $byteString;
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
        return new self(pack("H*", $hex), $bitSize);
    }

    /**
     * @param integer      $start
     * @param integer|null $end
     * @return Buffer
     * @throws \Exception
     */
    public function slice($start, $end = null)
    {
        if ($start > $this->getSize()) {
            throw new \Exception('Start exceeds buffer length');
        }

        if ($end === null) {
            return new self(substr($this->getBinary(), $start));
        }

        if ($end > $this->getSize()) {
            throw new \Exception('Length exceeds buffer length');
        }

        return new self(substr($this->getBinary(), $start, $end));
    }

    /**
     * Get the size of the buffer to be returned
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get the size of the value stored in the buffer
     *
     * @return int
     */
    public function getInternalSize()
    {
        return strlen($this->buffer);
    }

    /**
     * @return string
     */
    public function getBinary()
    {
        // if a size is specified we'll make sure the value returned is that size
        if ($this->size !== null) {
            if (strlen($this->buffer) < $this->size) {
                return str_pad($this->buffer, $this->size, chr(0), STR_PAD_LEFT);
            } elseif (strlen($this->buffer) > $this->size) {
                return substr($this->buffer, 0, $this->size);
            }
        }

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
}
