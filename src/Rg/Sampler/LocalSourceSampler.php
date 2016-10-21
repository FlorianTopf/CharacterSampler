<?php
namespace Rg\Sampler;

use Rg\Generator\RandomStringGenerator;

class LocalSourceSampler implements SamplerInterface
{
    /**
     * @var RandomStringGenerator
     */
    protected $randomStringGenerator;

    /**
     * @param RandomStringGenerator $randomStringGenerator
     */
    public function __construct(RandomStringGenerator $randomStringGenerator)
    {
        $this->randomStringGenerator = $randomStringGenerator;
    }

    /**
     * @inheritdoc
     */
    public function create($sampleSize)
    {
        return $this->randomStringGenerator->generate($sampleSize);
    }
}
