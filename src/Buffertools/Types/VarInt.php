<?php

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;
use Mdanter\Ecc\Math\GmpMathInterface;

class VarInt extends AbstractType
{
    private $sizeInfo = [];

    /**
     * @param GmpMathInterface $math
     * @param int                  $byteOrder
     */
    public function __construct(GmpMathInterface $math, $byteOrder = ByteOrder::BE)
    {
        parent::__construct($math, $byteOrder);
        $two = gmp_init(2, 10);
        $this->sizeInfo = [
            [Uint16::class, $math->pow($two, 16), gmp_init(0xfd)],
            [Uint32::class, $math->pow($two, 32), gmp_init(0xfe)],
            [Uint64::class, $math->pow($two, 64), gmp_init(0xff)],
        ];
    }

    /**
     * @param \GMP $integer
     * @return array
     */
    public function solveWriteSize(\GMP $integer)
    {
        $math = $this->getMath();

        foreach ($this->sizeInfo as $config) {
            list($uint, $limit, $prefix) = $config;
            if ($math->cmp($integer, $limit) < 0) {
                return [
                    new $uint($math, ByteOrder::LE),
                    $prefix
                ];
            }
        }

        throw new \InvalidArgumentException('Integer too large, exceeds 64 bit');
    }

    /**
     * @param \GMP $givenPrefix
     * @return UintInterface[]
     * @throws \InvalidArgumentException
     */
    public function solveReadSize(\GMP $givenPrefix)
    {
        $math = $this->getMath();

        foreach ($this->sizeInfo as $config) {
            $uint = $config[0];
            $prefix = $config[2];
            if ($math->cmp($givenPrefix, $prefix) === 0) {
                return [
                    new $uint($math, ByteOrder::LE)
                ];
            }
        }

        throw new \InvalidArgumentException('Integer too large, exceeds 64 bit');
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::write()
     */
    public function write($integer)
    {
        $math = $this->getMath();

        $gmp = gmp_init($integer, 10);
        $uint8 = new Uint8($math);
        if ($math->cmp($gmp, gmp_init(0xfd, 10)) < 0) {
            $int = $uint8;
        } else {
            list ($int, $prefix) = $this->solveWriteSize($gmp);
            $prefix = gmp_strval($prefix, 10);
        }

        $prefix = isset($prefix) ? $uint8->write($prefix) : '';
        $bits = $prefix . $int->write($integer);

        return $bits;
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::read()
     */
    public function read(Parser $parser)
    {
        $math = $this->getMath();
        $uint8 = new Uint8($math);
        $int = gmp_init($uint8->readBits($parser), 10);

        if ($math->cmp($int, gmp_init(0xfd, 10)) < 0) {
            return gmp_strval($int, 10);
        } else {
            $uint = $this->solveReadSize($int)[0];
            return $uint->read($parser);
        }
    }
}
