<?php
namespace Rg\Cli;

use Rg\Reader\StreamFileReader;
use Rg\Sampler\CharacterSamplerFactory;

class CharacterSamplerCli
{
    const DEFAULT_SAMPLE_SIZE = 5;

    /**
     * @var StreamFileReader
     */
    protected $streamFileReader;

    /**
     * @param StreamFileReader $streamFileReader
     */
    public function __construct(StreamFileReader $streamFileReader) {
        $this->streamFileReader = $streamFileReader;
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
        return CharacterSamplerFactory::choose($sampleType, $this->streamFileReader)->create($sampleSize);
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
}
