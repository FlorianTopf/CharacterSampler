<?php
namespace Rg\Generator;

class RandomIntegerGenerator
{
    // TODO replace mt_rand with random_int or external library
    /**
     * @param int $maximum
     *
     * @return int
     */
    public function generate($maximum)
    {
        return mt_rand(0, $maximum);
    }
}
