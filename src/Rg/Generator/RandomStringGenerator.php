<?php
namespace Rg\Generator;

class RandomStringGenerator
{
    /**
     * @var RandomIntegerGenerator
     */
    protected $randomIntegerGenerator;

    /**
     * @param RandomIntegerGenerator $randomIntegerGenerator
     */
    public function __construct(RandomIntegerGenerator $randomIntegerGenerator)
    {
        $this->randomIntegerGenerator = $randomIntegerGenerator;
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function generate($length)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $sample = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $sample .= $characters[$this->randomIntegerGenerator->generate($max)];
        }

        return $sample;
    }
}
