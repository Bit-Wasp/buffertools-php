<?php

namespace BitWasp\Buffertools;

use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Math\GmpMathInterface;

class Buffer implements BufferInterface
{
    /**
     * @var int
     */
    protected $size;

    /**
     * @var string
     */
    protected $buffer;

    /**
     * @var GmpMathInterface
     */
    protected $math;

    /**
     * @param string               $byteString
     * @param null|integer         $byteSize
     * @param GmpMathInterface     $math
     * @throws \Exception
     */
    public function __construct($byteString = '', $byteSize = null, GmpMathInterface $math = null)
    {
        $this->math = $math ?: EccFactory::getAdapter();
        if ($byteSize !== null) {
            // Check the integer doesn't overflow its supposed size
            if (strlen($byteString) > $byteSize) {
                throw new \Exception('Byte string exceeds maximum size');
            }
        } else {
            $byteSize = strlen($byteString);
        }

        $this->size   = $byteSize;
        $this->buffer = $byteString;
    }

    /**
     * Return a formatted version for var_dump
     */
    public function __debugInfo()
    {
        return [
            'size' => $this->size,
            'buffer' => '0x' . unpack("H*", $this->buffer)[1],
        ];
    }

    /**
     * Create a new buffer from a hex string
     *
     * @param string $hexString
     * @param integer $byteSize
     * @param GmpMathInterface $math
     * @return Buffer
     * @throws \Exception
     */
    public static function hex($hexString = '', $byteSize = null, GmpMathInterface $math = null)
    {
        if (strlen($hexString) > 0 && !ctype_xdigit($hexString)) {
            throw new \InvalidArgumentException('Buffer::hex: non-hex character passed');
        }

        $math = $math ?: EccFactory::getAdapter();
        $binary = pack("H*", $hexString);
        return new self($binary, $byteSize, $math);
    }

    /**
     * @param int|string $integer
     * @param null|int $byteSize
     * @param GmpMathInterface|null $math
     * @return Buffer
     */
    public static function int($integer, $byteSize = null, GmpMathInterface $math = null)
    {
        if ($integer < 0) {
            throw new \InvalidArgumentException('Negative integers not supported by Buffer::int. This could be an application error, or you should be using templates.');
        }

        $math = $math ?: EccFactory::getAdapter();
        $binary = pack("H*", $math->decHex($integer));
        return new self($binary, $byteSize, $math);
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

        $string = substr($this->getBinary(), $start, $end);
        if (!is_string($string)) {
            throw new \RuntimeException('Failed to slice string of with requested start/end');
        }

        $length = strlen($string);
        return new self($string, $length, $this->math);
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
        return unpack("H*", $this->getBinary())[1];
    }

    /**
     * @return \GMP
     */
    public function getGmp()
    {
        $gmp = gmp_init($this->getHex(), 16);
        return $gmp;
    }

    /**
     * @return int|string
     */
    public function getInt()
    {
        return gmp_strval($this->getGmp(), 10);
    }

    /**
     * @return BufferInterface
     */
    public function flip()
    {
        return Buffertools::flipBytes($this);
    }

    /**
     * @param BufferInterface $other
     * @return bool
     */
    public function equals(BufferInterface $other)
    {
        return ($other->getSize() === $this->getSize()
             && $other->getBinary() === $this->getBinary());
    }
}
