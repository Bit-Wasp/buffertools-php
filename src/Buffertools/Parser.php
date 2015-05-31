<?php

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Exceptions\ParserOutOfRange;
use Mdanter\Ecc\EccFactory;

class Parser
{
    /**
     * @var string
     */
    private $string;

    /**
     * @var \Mdanter\Ecc\MathAdapterInterface
     */
    private $math;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * Instantiate class, optionally taking a given hex string or Buffer.
     *
     * @param  string|Buffer|null $input
     * @throws \Exception
     */
    public function __construct($input = null)
    {
        $this->math = EccFactory::getAdapter();

        if (!$input instanceof Buffer) {
            $input = Buffer::hex($input);
        }

        $this->string = $input->getBinary();
        $this->position = 0;
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
     * Parse a vector from a string of data. Vectors are arrays, prefixed
     * by the number of items in the list.
     *
     * @param  callable $callback
     * @return array
     */
    public function getArray(callable $callback)
    {
        $results = array();
        $varInt  = $this->getVarInt();
        $txCount = $varInt->getInt();

        for ($i = 0; $i < $txCount; $i++) {
            $results[] = $callback($this);
        }

        return $results;
    }

    /**
     * Parse a variable length integer
     *
     * @return Buffer
     * @throws \Exception
     */
    public function getVarInt()
    {
        // Return the length encoded in this var int
        $byte   = $this->readBytes(1);
        $int    = $byte->getInt();

        if ($this->math->cmp($int, 0xfd) < 0) {
            return $byte;
        } elseif ($this->math->cmp($int, 0xfd) == 0) {
            return $this->readBytes(2, true);
        } elseif ($this->math->cmp($int, 0xfe) == 0) {
            return $this->readBytes(4, true);
        } elseif ($this->math->cmp($int, 0xff) == 0) {
            return $this->readBytes(8, true);
        }

        throw new \Exception('Data too large');
    }

    /**
     * Return a variable length string. This is a variable length string,
     * prefixed with it's length encoded as a VarInt.
     *
     * @return Buffer
     * @throws \Exception
     */
    public function getVarString()
    {
        $varInt = $this->getVarInt()->getInt();
        if ($this->math->cmp($varInt, 0) == 0) {
            return new Buffer();
        }
        $string = $this->readBytes($varInt);
        return $string;
    }

    /**
     * Parse $bytes bytes from the string, and return the obtained buffer
     *
     * @param  integer $bytes
     * @param  bool    $flipBytes
     * @return Buffer
     * @throws \Exception
     */
    public function readBytes($bytes, $flipBytes = false)
    {
        $string = substr($this->string, $this->getPosition(), $bytes);
        $length = strlen($string);

        if ($length == 0) {
            throw new ParserOutOfRange('Could not parse string of required length (empty)');
        } elseif ($this->math->cmp($length, $bytes) !== 0) {
            throw new ParserOutOfRange('Could not parse string of required length (too short)');
        }

        $this->position += $bytes;

        if ($flipBytes) {
            $string = Buffertools::flipBytes($string);
        }

        $buffer = new Buffer($string);
        return $buffer;
    }

    /**
     * Write $data as $bytes bytes. Can be flipped if needed.
     *
     * @param  integer $bytes
     * @param  $data
     * @param  bool    $flipBytes
     * @return $this
     */
    public function writeBytes($bytes, $data, $flipBytes = false)
    {
        // Treat $data to ensure it's a buffer, with the correct size
        if ($data instanceof SerializableInterface) {
            $data = $data->getBuffer();
        }

        if ($data instanceof Buffer) {
            // only create a new buffer if the size does not match
            if ($data->getSize() != $bytes) {
                $data = new Buffer($data->getBinary(), $bytes);
            }
        } else {
            // Convert to a buffer
            $data = Buffer::hex($data, $bytes);
        }

        // At this point $data will be a Buffer
        $binary = $data->getBinary();

        if ($flipBytes) {
            $binary = Buffertools::flipBytes($binary);
        }

        $this->string .= $binary;
        return $this;
    }

    /**
     * Write with length - Writes a buffer and prefixes it with it's length,
     * as a VarInt
     *
     * @param  Buffer $buffer
     * @return $this
     * @throws \Exception
     */
    public function writeWithLength(Buffer $buffer)
    {
        $varInt = Buffertools::numToVarInt($buffer->getSize());
        $buffer = new Buffer($varInt->getBinary() . $buffer->getBinary());
        $this->writeBytes($buffer->getSize(), $buffer);
        return $this;
    }

    /**
     * Take an array containing serializable objects.
     * @param SerializableInterface[]|Buffer[]
     * @return $this
     */
    public function writeArray($serializable)
    {
        $parser = new Parser(Buffertools::numToVarInt(count($serializable)));
        foreach ($serializable as $object) {
            if ($object instanceof SerializableInterface) {
                $object = $object->getBuffer();
            }

            if ($object instanceof Buffer) {
                $parser->writeBytes($object->getSize(), $object);
            } else {
                throw new \RuntimeException('Input to writeArray must be Buffer[], or SerializableInterface[]');
            }
        }

        $this->string .= $parser->getBuffer()->getBinary();

        return $this;
    }

    /**
     * Write an integer to the buffer
     *
     * @param  integer $bytes
     * @param  $int
     * @param  bool    $flipBytes
     * @return $this
     */
    public function writeInt($bytes, $int, $flipBytes = false)
    {
        $hex  = str_pad($this->math->decHex($int), $bytes * 2, '0', STR_PAD_LEFT);
        $data = pack("H*", $hex);

        if ($flipBytes) {
            $data = Buffertools::flipBytes($data);
        }

        $this->string .= $data;

        return $this;
    }

    /**
     * Return the string as a buffer
     *
     * @return Buffer
     */
    public function getBuffer()
    {
        $buffer = new Buffer($this->string);
        return $buffer;
    }

    /**
     * Extract $bytes from the parser, and return them as a new Parser instance.
     *
     * @param  $bytes
     * @param  bool  $flipBytes
     * @return Parser
     * @throws \Exception
     */
    public function parseBytes($bytes, $flipBytes = false)
    {
        $buffer = $this->readBytes($bytes, $flipBytes);
        $parser = new Parser($buffer);
        return $parser;
    }
}
