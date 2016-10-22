<?php
namespace Rg\Sampler;

use Rg\Client\CurlClient;

class HttpSourceSampler implements SamplerInterface
{
    use HasStringFormatter;

    /**
     * @var CurlClient
     */
    protected $curlClient;

    /**
     * @param CurlClient $curlClient
     */
    public function __construct(CurlClient $curlClient)
    {
        $this->curlClient = $curlClient;
    }

    /**
     * @inheritdoc
     *
     * A single sample size must be between [1, 20] at random.org so
     * the function combines multiple samples if needed.
     */
    public function create($sampleSize)
    {
        $chunkAmount = (int) ceil($sampleSize / 20);

        $response = $this->curlClient->send(
            'https://www.random.org/strings/',
            [
                'num' => $chunkAmount,
                'len' => $sampleSize <= 20 ? $sampleSize : 20,
                'digits' => 'on',
                'upperalpha' => 'on',
                'loweralpha' => 'on',
                'unique' => 'on',
                'format' => 'plain',
                'rnd' => 'new'
            ]
        );

        $sample = $this->stripLineBreaks($response);

        return substr($sample, 0, $sampleSize);
    }
}
