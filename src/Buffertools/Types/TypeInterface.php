<?php

declare(strict_types=1);

namespace BitWasp\Buffertools\Types;

use BitWasp\Buffertools\Parser;
use Mdanter\Ecc\Math\GmpMathInterface;

interface TypeInterface
{
    /**
     * Return the math adapter
     *
     * @return \Mdanter\Ecc\Math\GmpMathInterface
     */
    public function getMath(): GmpMathInterface;

    /**
     * Flip whatever bitstring is given to us
     *
     * @param  string $bitString
     * @return string
     */
    public function flipBits(string $bitString): string;

    /**
     * @param mixed $integer
     * @return string
     */
    public function write($integer): string;

    /**
     * @param Parser $parser
     * @return mixed
     */
    public function read(Parser $parser);

    /**
     * @return int|string
     */
    public function getByteOrder(): int;
}
