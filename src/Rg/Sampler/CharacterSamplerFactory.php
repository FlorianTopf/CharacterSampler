<?php
namespace Rg\Sampler;

use Rg\Client\CurlClient;
use Rg\Generator\RandomIntegerGenerator;
use Rg\Generator\RandomStringGenerator;

class CharacterSamplerFactory
{
    /**
     * @param $sampleType
     * @param $streamFileReader
     *
     * @return SamplerInterface
     */
    static function choose($sampleType, $streamFileReader) {
        switch ($sampleType) {
            case 'remote':
                echo 'Using Remote Sampler' . PHP_EOL;
                return new HttpSourceSampler(new CurlClient());
            case 'file':
                echo 'Using File Sampler' . PHP_EOL;
                return new StreamFileSampler($streamFileReader, new RandomIntegerGenerator());
            case 'local':
            default:
                echo 'Using Local Sampler' . PHP_EOL;
                return new LocalSourceSampler(new RandomStringGenerator(new RandomIntegerGenerator()));
        }
    }
}
