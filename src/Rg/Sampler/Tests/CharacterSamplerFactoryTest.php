<?php
namespace Rg\Sampler\Tests;

use Rg\Reader\StreamFileReader;
use Rg\Sampler\CharacterSamplerFactory;
use Rg\Sampler\HttpSourceSampler;
use Rg\Sampler\LocalSourceSampler;
use Rg\Sampler\StreamFileSampler;

class CharacterSamplerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCanChoose()
    {
        $this->assertInstanceOf(
            HttpSourceSampler::class,
            CharacterSamplerFactory::choose('remote', $this->getStreamFileReaderMock())
        );
        $this->assertInstanceOf(
            StreamFileSampler::class,
            CharacterSamplerFactory::choose('file', $this->getStreamFileReaderMock())
        );
        $this->assertInstanceOf(
            LocalSourceSampler::class,
            CharacterSamplerFactory::choose('local', $this->getStreamFileReaderMock())
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StreamFileReader
     */
    protected function getStreamFileReaderMock()
    {
        return static::getMockBuilder(StreamFileReader::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
