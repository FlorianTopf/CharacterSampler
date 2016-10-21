<?php
namespace Rg\Sampler;

use Rg\Client\CurlClient;

class HttpSourceSampler implements SamplerInterface
{
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
     * sample size must be between [1, 20] at random.org
     */
    public function create($sampleSize)
    {
        return $this->curlClient->send(
            'https://www.random.org/strings/',
            [
                'num' => 1,
                'len' => $sampleSize <= 20 ? $sampleSize : 20,
                'digits' => 'on',
                'upperalpha' => 'on',
                'loweralpha' => 'on',
                'unique' => 'on',
                'format' => 'plain',
                'rnd' => 'new'
            ]
        );
    }
}
