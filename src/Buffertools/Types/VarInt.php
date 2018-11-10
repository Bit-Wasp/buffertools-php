<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\ByteOrder;
use BitWasp\Buffertools\Parser;

class VarInt extends AbstractType
{
    /**
     * @param \GMP $integer
     * @return array
     */
    public function solveWriteSize(\GMP $integer)
    {
        if (gmp_cmp($integer, gmp_pow(gmp_init(2), 16)) < 0) {
            return [new Uint16($this->getMath(), ByteOrder::LE), 0xfd];
        } else if (gmp_cmp($integer, gmp_pow(gmp_init(2), 32)) < 0) {
            return [new Uint32($this->getMath(), ByteOrder::LE), 0xfe];
        } else if (gmp_cmp($integer, gmp_pow(gmp_init(2), 64)) < 0) {
            return [new Uint64($this->getMath(), ByteOrder::LE), 0xff];
        } else {
            throw new \InvalidArgumentException('Integer too large, exceeds 64 bit');
        }
    }

    /**
     * @param \GMP $givenPrefix
     * @return UintInterface[]
     * @throws \InvalidArgumentException
     */
    public function solveReadSize(\GMP $givenPrefix)
    {
        if (gmp_cmp($givenPrefix, 0xfd) === 0) {
            return [new Uint16($this->getMath(), ByteOrder::LE)];
        } else if (gmp_cmp($givenPrefix, 0xfe) === 0) {
            return [new Uint32($this->getMath(), ByteOrder::LE)];
        } else if (gmp_cmp($givenPrefix, 0xff) === 0) {
            return [new Uint64($this->getMath(), ByteOrder::LE)];
        }

        throw new \InvalidArgumentException('Unknown varint prefix');
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::write()
     */
    public function write($integer)
    {
        $gmpInt = gmp_init($integer, 10);
        if (gmp_cmp($gmpInt, gmp_init(0xfd, 10)) < 0) {
            return pack("C", $integer);
        }
        list ($int, $prefix) = $this->solveWriteSize($gmpInt);
        return pack("C", $prefix) . $int->write($integer);
    }

    /**
     * {@inheritdoc}
     * @see \BitWasp\Buffertools\Types\TypeInterface::read()
     */
    public function read(Parser $parser)
    {
        $byte = unpack("C", $parser->readBytes(1)->getBinary())[1];
        if ($byte < 0xfd) {
            return $byte;
        }

        list ($uint) = $this->solveReadSize(gmp_init($byte, 10));
        return $uint->read($parser);
    }
}
