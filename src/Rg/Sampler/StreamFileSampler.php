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
     *
     * If the input size is big enough to support multiple read iterations the sampler will pick characters
     * horizontally and vertically
     */
    public function create($sampleSize)
    {
        $possibleReadIterations = $this->streamFileReader->getReadIterations();

        if (0 === $possibleReadIterations) {
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
        $chunk = $this->streamFileReader->read();
        return $this->pickRandomCharactersFromChunk($chunk, $sampleSize);
    }

    /**
     * @param int $sampleSize
     *
     * @return string
     *
     * If sample size exceeds possible iterations the function picks more then one character per iteration
     * Due to rounding of the characters per iteration, the final sample must be cut to fit the sample size
     */
    protected function extractFromMultipleChunks($sampleSize)
    {
        $sample = '';
        $possibleReadIterations = $this->streamFileReader->getReadIterations();
        $randomChunkIndexes = $this->randomIntegerGenerator->generateBatch(
            $possibleReadIterations,
            $sampleSize
        );

        $charactersPerIteration = 1;
        if ($sampleSize > $possibleReadIterations) {
            $charactersPerIteration = (int) ceil($sampleSize / $possibleReadIterations);
        }

        $currentChunkIndex = 0;
        while (false !== ($chunk = $this->streamFileReader->read())) {
            if (in_array($currentChunkIndex, $randomChunkIndexes)) {
                $sample .= $this->pickRandomCharactersFromChunk($chunk, $charactersPerIteration);
            }
            $currentChunkIndex++;
        }

        return substr($sample, 0, $sampleSize);
    }

    /**
     * @param string $chunk
     * @param int $sampleSize
     *
     * @return string
     *
     * If the sample size exceeds the available data the function does several iterations over the same chunk
     */
    protected function pickRandomCharactersFromChunk($chunk, $sampleSize)
    {
        $chunk = $this->stripLineBreaks($chunk);

        $sample = '';
        $neededReadIterations = (int) ceil($sampleSize / strlen($chunk));

        for ($iteration = 1; $iteration <= $neededReadIterations; $iteration++) {
            $randomCharacterIndexes = $this->randomIntegerGenerator->generateBatch(strlen($chunk) - 1, $sampleSize);

            foreach ($randomCharacterIndexes as $index) {
                $sample .= $chunk[$index];
            }
        }

        return $sample;
    }
}
