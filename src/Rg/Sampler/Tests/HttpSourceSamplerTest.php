<?php
namespace Rg\Sampler\Tests;

use Rg\Client\CurlClient;
use Rg\Sampler\HttpSourceSampler;

class HttpSourceSamplerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    public function testCanCreate()
    {
        $curlClientMock = $this->getCurlClientMock();
        $httpSourceSampler = new HttpSourceSampler($curlClientMock);

        $curlClientMock->expects(static::once())
            ->method('send')
            ->with(
                'https://www.random.org/strings/',
                [
                    'num' => 1,
                    'len' => 5,
                    'digits' => 'on',
                    'upperalpha' => 'on',
                    'loweralpha' => 'on',
                    'unique' => 'on',
                    'format' => 'plain',
                    'rnd' => 'new'
                ]
            )
            ->willReturn('ABCDE');

        $this->assertEquals('ABCDE', $httpSourceSampler->create(5));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|CurlClient
     */
    protected function getCurlClientMock()
    {
        return static::getMock(CurlClient::class);
    }
}
