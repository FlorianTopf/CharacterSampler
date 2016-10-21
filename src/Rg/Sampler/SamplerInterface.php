<?php
namespace Rg\Sampler;

interface SamplerInterface
{
    /**
     * @param int $sampleSize
     *
     * @return string
     */
    public function create($sampleSize);
}
