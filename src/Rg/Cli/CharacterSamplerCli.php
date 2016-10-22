<?php
namespace Rg\Cli;

use Rg\Client\CurlClient;
use Rg\Generator\RandomIntegerGenerator;
use Rg\Generator\RandomStringGenerator;
use Rg\Reader\StreamFileReader;
use Rg\Sampler\HttpSourceSampler;
use Rg\Sampler\LocalSourceSampler;
use Rg\Sampler\SamplerInterface;
use Rg\Sampler\StreamFileSampler;

class CharacterSamplerCli
{
    const DEFAULT_SAMPLE_SIZE = 5;

    /**
     * @var StreamFileReader
     */
    protected $streamFileReader;

    /**
     * @var CurlClient
     */
    protected $curlClient;

    /**
     * @var RandomIntegerGenerator
     */
    protected $randomIntegerGenerator;

    /**
     * @var RandomStringGenerator
     */
    protected $randomStringGenerator;

    /**
     * @param StreamFileReader $streamFileReader
     * @param CurlClient $curlClient
     * @param RandomIntegerGenerator $randomIntegerGenerator
     * @param RandomStringGenerator $randomStringGenerator
     */
    public function __construct(
        StreamFileReader $streamFileReader,
        CurlClient $curlClient,
        RandomIntegerGenerator $randomIntegerGenerator,
        RandomStringGenerator $randomStringGenerator
    ) {
        $this->streamFileReader = $streamFileReader;
        $this->curlClient = $curlClient;
        $this->randomIntegerGenerator = $randomIntegerGenerator;
        $this->randomStringGenerator = $randomStringGenerator;
    }

    /**
     * @param string[] $cliArguments
     *
     * @return string
     */
    public function getSample(array $cliArguments)
    {
        $sampleType = $this->getSampleType($cliArguments);
        $sampleSize = $this->getSampleSize($cliArguments);
        return $this->chooseSampler($sampleType)->create($sampleSize);
    }

    /**
     * @param string[] $cliArguments
     *
     * @return string
     */
    protected function getSampleType(array $cliArguments)
    {
        $sampleType = 'local';
        if (0 < $this->streamFileReader->getFileSize()) {
            $sampleType = 'file';
        } else if (array_key_exists('type', $cliArguments)) {
            $sampleType = $cliArguments['type'];
        }

        return $sampleType;
    }

    /**
     * @param string[] $cliArguments
     *
     * @return int
     */
    protected function getSampleSize(array $cliArguments)
    {
        return (int) $cliArguments['size'] ?: static::DEFAULT_SAMPLE_SIZE;
    }

    /**
     * @param string $sampleType
     *
     * @return SamplerInterface
     */
    protected function chooseSampler($sampleType) {
        switch ($sampleType) {
            case 'remote':
                echo 'using remote sampler' . PHP_EOL;
                return new HttpSourceSampler($this->curlClient);
            case 'file':
                echo 'using file sampler' . PHP_EOL;
                return new StreamFileSampler(
                    $this->streamFileReader,
                    $this->randomIntegerGenerator
                );
            case 'local':
            default:
                echo 'using local sampler' . PHP_EOL;
                return new LocalSourceSampler($this->randomStringGenerator);
        }
    }
}
