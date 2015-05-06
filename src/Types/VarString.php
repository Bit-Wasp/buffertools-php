<?php

namespace BitWasp\Buffertools\Types;


use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\Parser;

class VarString extends AbstractType
{
    /**
     * @var VarInt
     */
    private $varint;

    /**
     * @param VarInt $varInt
     */
    public function __construct(VarInt $varInt)
    {
        $this->varint = $varInt;
        parent::__construct($varInt->getMath(), $varInt->getByteOrder());
    }

    /**
     * @param Buffer $buffer
     * @return string
     */
    public function write($buffer)
    {
        if (!$buffer instanceof Buffer) {
            throw new \InvalidArgumentException('Must provide a buffer');
        }

        $binary = $this->varint->write($buffer->getSize()) . $buffer->getBinary();
        return $binary;
    }

    /**
     * @param Parser $parser
     * @return \BitWasp\Buffertools\Buffer
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     * @throws \Exception
     */
    public function read(Parser & $parser)
    {
        $length = $this->varint->read($parser);

        if ($this->varint->getMath()->cmp($length, 0) == 0) {
            return new Buffer();
        }

        return $parser->readBytes($length);
    }

}