<?php

declare(strict_types=1);

namespace BitWasp\Buffertools;

use BitWasp\Buffertools\Exceptions\ParserOutOfRange;

class Parser
{
    /**
     * @var string
     */
    private $string = '';

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
     * @param BufferInterface $input
     */
    public function __construct(BufferInterface $input = null)
    {
        if ($input instanceof BufferInterface) {
            $this->string = $input->getBinary();
            $this->size = $input->getSize();
            assert(strlen($this->string) === $this->size);
        }
    }

    /**
     * Get the position pointer of the parser - ie, how many bytes from 0
     *
     * @return int
     */
    public function getPosition(): int
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
     * @param  int $numBytes
     * @param  bool $flipBytes
     * @return BufferInterface
     * @throws \Exception
     */
    public function readBytes(int $numBytes, bool $flipBytes = false): BufferInterface
    {
        $string = substr($this->string, $this->getPosition(), $numBytes);
        $length = strlen($string);

        if ($length === 0) {
            throw new ParserOutOfRange('Could not parse string of required length (empty)');
        } elseif ($length < $numBytes) {
            throw new ParserOutOfRange('Could not parse string of required length (too short)');
        }

        $this->position += $numBytes;

        if ($flipBytes) {
            $string = Buffertools::flipBytes($string);
            /** @var string $string */
        }

        return new Buffer($string, $length);
    }

    /**
     * @param BufferInterface $buffer
     * @param bool $flipBytes
     * @return Parser
     */
    public function appendBuffer(BufferInterface $buffer, bool $flipBytes = false): Parser
    {
        $this->appendBinary($buffer->getBinary(), $flipBytes);
        return $this;
    }

    /**
     * @param string $binary
     * @param bool $flipBytes
     * @return Parser
     */
    public function appendBinary(string $binary, bool $flipBytes = false): Parser
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
     * @param SerializableInterface[]|BufferInterface[] $serializable
     * @return Parser
     */
    public function writeArray(array $serializable): Parser
    {
        $parser = new Parser(Buffertools::numToVarInt(count($serializable)));
        foreach ($serializable as $object) {
            if ($object instanceof SerializableInterface) {
                $object = $object->getBuffer();
            }

            if ($object instanceof BufferInterface) {
                $parser->appendBinary($object->getBinary());
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
    public function getBuffer(): BufferInterface
    {
        return new Buffer($this->string, $this->size);
    }
}
