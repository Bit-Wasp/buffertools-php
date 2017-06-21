<?php

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Exceptions\ParserOutOfRange;
use Mdanter\Ecc\EccFactory;
use Mdanter\Ecc\Math\GmpMathInterface;

class Parser
{
    /**
     * @var string
     */
    private $string;

    /**
     * @var \Mdanter\Ecc\Math\GmpMathInterface
     */
    private $math;

    /**
     * @var int
     */
    private $size = 0;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * Instantiate class, optionally taking Buffer or HEX.
     *
     * @param null|string|BufferInterface $input
     * @param GmpMathInterface|null $math
     */
    public function __construct($input = null, GmpMathInterface $math = null)
    {
        $this->math = $math ?: EccFactory::getAdapter();

        if (!$input instanceof BufferInterface) {
            $input = Buffer::hex($input, null, $this->math);
        }

        $this->string = $input->getBinary();
        $this->position = 0;
        $this->size = strlen($this->string);
    }

    /**
     * Get the position pointer of the parser - ie, how many bytes from 0
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Get the total size of the parser
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Parse $bytes bytes from the string, and return the obtained buffer
     *
     * @param  integer $bytes
     * @param  bool $flipBytes
     * @return Buffer
     * @throws \Exception
     */
    public function readBytes($bytes, $flipBytes = false)
    {
        $string = substr($this->string, $this->getPosition(), $bytes);
        $length = strlen($string);

        if ($length == 0) {
            throw new ParserOutOfRange('Could not parse string of required length (empty)');
        } elseif ($length < $bytes) {
            throw new ParserOutOfRange('Could not parse string of required length (too short)');
        }

        $this->position += $bytes;

        if ($flipBytes) {
            $string = Buffertools::flipBytes($string);
        }

        return new Buffer($string, $length, $this->math);
    }

    /**
     * Write $data as $bytes bytes. Can be flipped if needed.
     *
     * @param  integer $bytes
     * @param  $data
     * @param  bool $flipBytes
     * @return $this
     */
    public function writeBytes($bytes, $data, $flipBytes = false)
    {
        // Treat $data to ensure it's a buffer, with the correct size
        if ($data instanceof SerializableInterface) {
            $data = $data->getBuffer();
        }

        if (is_string($data)) {
            // Convert to a buffer
            $data = Buffer::hex($data, $bytes, $this->math);
        } else if (!($data instanceof BufferInterface)) {
            throw new \RuntimeException('Invalid data passed to Parser::writeBytes');
        }

        $this->writeBuffer($bytes, $data, $flipBytes);

        return $this;
    }

    /**
     * Write $data as $bytes bytes. Can be flipped if needed.
     *
     * @param  integer $bytes
     * @param  string $data
     * @param  bool $flipBytes
     * @return $this
     */
    public function writeRawBinary($bytes, $data, $flipBytes = false)
    {
        return $this->writeBuffer($bytes, new Buffer($data, $bytes), $flipBytes);
    }

    /**
     * @param BufferInterface $buffer
     * @param bool $flipBytes
     * @param int $bytes
     * @return $this
     */
    public function writeBuffer($bytes, BufferInterface $buffer, $flipBytes = false)
    {
        // only create a new buffer if the size does not match
        if ($buffer->getSize() != $bytes) {
            $buffer = new Buffer($buffer->getBinary(), $bytes, $this->math);
        }

        $this->appendBuffer($buffer, $flipBytes);

        return $this;
    }

    /**
     * @param BufferInterface $buffer
     * @param bool $flipBytes
     * @return $this
     */
    public function appendBuffer(BufferInterface $buffer, $flipBytes = false)
    {
        $this->appendBinary($buffer->getBinary(), $flipBytes);
        return $this;
    }

    /**
     * @param string $binary
     * @param bool $flipBytes
     * @return $this
     */
    public function appendBinary($binary, $flipBytes = false)
    {
        if ($flipBytes) {
            $binary = Buffertools::flipBytes($binary);
        }

        $this->string .= $binary;
        $this->size += strlen($binary);
        return $this;
    }

    /**
     * Take an array containing serializable objects.
     * @param SerializableInterface[]|Buffer[]
     * @return $this
     */
    public function writeArray($serializable)
    {
        $parser = new Parser(Buffertools::numToVarInt(count($serializable)), $this->math);
        foreach ($serializable as $object) {
            if ($object instanceof SerializableInterface) {
                $object = $object->getBuffer();
            }

            if ($object instanceof BufferInterface) {
                $parser->writeBytes($object->getSize(), $object);
            } else {
                throw new \RuntimeException('Input to writeArray must be Buffer[], or SerializableInterface[]');
            }
        }

        $this->string .= $parser->getBuffer()->getBinary();
        $this->size += $parser->getSize();

        return $this;
    }

    /**
     * Return the string as a buffer
     *
     * @return BufferInterface
     */
    public function getBuffer()
    {
        return new Buffer($this->string, null, $this->math);
    }
}
