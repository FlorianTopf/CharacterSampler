<?php
namespace Rg\Generator;

class RandomIntegerBatchGenerator
{
    /**
     * @param int $maximum
     * @param int $amount
     *
     * @return int[]
     */
    public function generate($maximum, $amount)
    {
        $numbers = range(0, $maximum);
        shuffle($numbers);

        return array_slice($numbers, 0, $amount);
    }
}
