<?php
namespace Rg\Sampler;

use Rg\Generator\RandomIntegerGenerator;
use Rg\Reader\StreamFileReader;

class StreamFileSampler implements SamplerInterface
{
    use HasStringFormatter;

    /**
     * @var StreamFileReader
     */
    protected $streamFileReader;

    /**
     * @var RandomIntegerGenerator
     */
    protected $randomIntegerGenerator;

    /**
     * @param StreamFileReader $streamFileReader
     * @param RandomIntegerGenerator $randomIntegerGenerator
     */
    public function __construct(
        StreamFileReader $streamFileReader,
        RandomIntegerGenerator $randomIntegerGenerator
    ) {
        $this->streamFileReader = $streamFileReader;
        $this->randomIntegerGenerator = $randomIntegerGenerator;
    }

    /**
     * @inheritdoc
     */
    public function create($sampleSize)
    {
        $possibleReadIterations = $this->streamFileReader->getReadIterations();

        // if the amount of possible stream chunks is lower than sample size
        // the sample will be taken from one chunk
        if (0 === $possibleReadIterations || $sampleSize > $possibleReadIterations) {
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
        $chunk = $this->stripLineBreaks($this->streamFileReader->read());

        // if the sample size exceeds the available data the function does several iterations over the same stream
        $neededReadIterations = (int) floor($sampleSize / strlen($chunk));

        for ($iteration = 0; $iteration <= $neededReadIterations; $iteration++) {
            $randomCharacterIndexes = $this->randomIntegerGenerator->generateBatch(strlen($chunk) - 1, $sampleSize);

            foreach ($randomCharacterIndexes as $index) {
                $sample .= $chunk[$index];
            }
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
        $randomChunkIndexes = $this->randomIntegerGenerator->generateBatch(
            $this->streamFileReader->getReadIterations(),
            $sampleSize
        );
        $currentChunkIndex = 0;

        while (false !== ($chunk = $this->streamFileReader->read())) {
            if (in_array($currentChunkIndex, $randomChunkIndexes)) {
                $chunk = $this->stripLineBreaks($chunk);
                $randomCharacterIndex = $this->randomIntegerGenerator->generate(strlen($chunk) - 1);
                $sample .= $chunk[$randomCharacterIndex];
            }
            $currentChunkIndex++;
        }

        return $sample;
    }
}
