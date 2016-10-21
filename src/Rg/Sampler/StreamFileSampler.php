<?php
namespace Rg\Sampler;

use Rg\Generator\RandomIntegerBatchGenerator;
use Rg\Generator\RandomIntegerGenerator;
use Rg\Reader\StreamFileReader;

class StreamFileSampler implements SamplerInterface
{
    /**
     * @var StreamFileReader
     */
    protected $streamFileReader;

    /**
     * @var RandomIntegerGenerator
     */
    protected $randomIntegerGenerator;

    /**
     * @var RandomIntegerBatchGenerator
     */
    protected $randomIntegerBatchGenerator;

    /**
     * @param StreamFileReader $streamFileReader
     * @param RandomIntegerGenerator $randomIntegerGenerator
     * @param RandomIntegerBatchGenerator $randomIntegerBatchGenerator
     */
    public function __construct(
        StreamFileReader $streamFileReader,
        RandomIntegerGenerator $randomIntegerGenerator,
        RandomIntegerBatchGenerator $randomIntegerBatchGenerator
    ) {
        $this->streamFileReader = $streamFileReader;
        $this->randomIntegerGenerator = $randomIntegerGenerator;
        $this->randomIntegerBatchGenerator = $randomIntegerBatchGenerator;
    }

    /**
     * @inheritdoc
     */
    public function create($sampleSize)
    {
        if (0 === $this->streamFileReader->getReadIterations()) {
            return $this->extractFromOneChunk($sampleSize);
        } else {
            return $this->extractFromMultipleChunks($sampleSize);
        }
    }

    /**
     * @param int $sampleSize
     *
     * @return string
     */
    protected function extractFromOneChunk($sampleSize)
    {
        $sample = '';
        $chunk = $this->streamFileReader->read();
        $randomIndexes = $this->randomIntegerBatchGenerator->generate(strlen($chunk) - 1, $sampleSize);

        foreach ($randomIndexes as $randomIndex) {
            $sample .= $chunk[$randomIndex];
        }
        return $sample;
    }

    /**
     * @param int $sampleSize
     *
     * @return string
     */
    protected function extractFromMultipleChunks($sampleSize)
    {
        $sample = '';
        $randomIndexes = $this->randomIntegerBatchGenerator->generate(
            $this->streamFileReader->getReadIterations(),
            $sampleSize
        );
        $currentChunkIndex = 0;

        while (false !== ($chunk = $this->streamFileReader->read())) {
            if (in_array($currentChunkIndex, $randomIndexes)) {
                $sample .= $chunk[$this->randomIntegerGenerator->generate(strlen($chunk) - 1)];
            }
            $currentChunkIndex++;
        }

        return $sample;
    }
}
