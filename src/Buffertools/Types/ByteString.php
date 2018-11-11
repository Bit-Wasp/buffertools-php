<?php

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\Buffer;
use BitWasp\Buffertools\BufferInterface;
use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;
use Mdanter\Ecc\Math\GmpMathInterface;

class ByteString extends AbstractType
{
    /**
     * @var int|string
     */
    private $length;

    /**
     * @param GmpMathInterface     $math
     * @param int|string           $length
     * @param int|string           $byteOrder
     */
    public function __construct(GmpMathInterface $math, $length, $byteOrder = ByteOrder::BE)
    {
        $this->length = $length;
        parent::__construct($math, $byteOrder);
    }

    /**
     * @param BufferInterface $string
     * @return string
     * @throws \Exception
     */
    public function write($string)
    {
        if (!($string instanceof BufferInterface)) {
            throw new \InvalidArgumentException('FixedLengthString::write() input must implement BufferInterface');
        }

        $data = new Buffer($string->getBinary(), $this->length);
        if (!$this->isBigEndian()) {
            $data = $data->flip();
        }

        return $data->getBinary();
    }

    /**
     * @param Parser $parser
     * @return BufferInterface
     * @throws \BitWasp\Buffertools\Exceptions\ParserOutOfRange
     */
    public function read(Parser $parser)
    {
        $data = $parser->readBytes($this->length);
        if (!$this->isBigEndian()) {
            $data = $data->flip();
        }

        return $data;
    }
}
