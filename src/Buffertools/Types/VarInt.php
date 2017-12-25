<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;

class VarInt extends AbstractType
{
    /**
     * @var array
     */
    private $sizeInfo = [];

    /**
     * @param int $byteOrder
     */
    public function __construct(int $byteOrder = ByteOrder::BE)
    {
        parent::__construct($byteOrder);
        $two = gmp_init(2, 10);
        $this->sizeInfo = [
            [Uint16::class, gmp_pow($two, 16), 0xfd],
            [Uint32::class, gmp_pow($two, 32), 0xfe],
            [Uint64::class, gmp_pow($two, 64), 0xff],
        ];
    }

    /**
     * @param \GMP $integer
     * @return array
     */
    public function solveWriteSize(\GMP $integer): array
    {
        foreach ($this->sizeInfo as $config) {
            list($uint, $limit, $prefix) = $config;
            if (gmp_cmp($integer, $limit) < 0) {
                return [
                    new $uint(ByteOrder::LE),
                    $prefix
                ];
            }
        }

        throw new \InvalidArgumentException('Integer too large, exceeds 64 bit');
    }

    /**
     * @param int $givenPrefix
     * @return UintInterface[]
     * @throws \InvalidArgumentException
     */
    public function solveReadSize(int $givenPrefix): array
    {
        foreach ($this->sizeInfo as $config) {
            $uint = $config[0];
            $prefix = $config[2];
            if ($givenPrefix === $prefix) {
                return [
                    new $uint(ByteOrder::LE)
                ];
            }
        }

        throw new \InvalidArgumentException('Integer too large, exceeds 64 bit');
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::write()
     */
    public function write($integer): string
    {
        $gmp = gmp_init($integer, 10);
        $uint8 = new Uint8();
        if (gmp_cmp($gmp, gmp_init(0xfd, 10)) < 0) {
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
    public function read(Parser $parser): string
    {
        $uint8 = new Uint8();
        $int = (int) $uint8->readBits($parser);

        if ($int < 0xfd) {
            return (string) $int;
        } else {
            $uint = $this->solveReadSize($int)[0];
            return $uint->read($parser);
        }
    }
}
