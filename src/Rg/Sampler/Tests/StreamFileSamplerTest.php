<?php
namespace Rg\Sampler\Tests;

use Rg\Generator\RandomIntegerGenerator;
use Rg\Reader\StreamFileReader;
use Rg\Sampler\StreamFileSampler;

class StreamFileSamplerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCanCreateFromOneChunk()
    {
        $chunk = 'THEQUICKBROWNFOX' . PHP_EOL . 'JUMPSOVERTHELAZYDOG' . PHP_EOL;
        $streamFileReaderMock = $this->getStreamFileReaderMock();
        $randomIntegerGeneratorMock = $this->getRandomIntegerGeneratorMock();

        $streamFileSampler = new StreamFileSampler($streamFileReaderMock, $randomIntegerGeneratorMock);

        $streamFileReaderMock->expects(static::once())
            ->method('getReadIterations')
            ->willReturn(0);

        $streamFileReaderMock->expects(static::once())
            ->method('read')
            ->willReturn($chunk);

        $randomIntegerGeneratorMock->expects(static::once())
            ->method('generateBatch')
            ->with(34, 5)
            ->willReturn([0, 1, 2, 3, 4]);

        $this->assertEquals('THEQU', $streamFileSampler->create(5));
    }

    /**
     * @test
     */
    public function testCanCreateFromMultipleChunks()
    {
        $chunk = 'THEQUICKBROWNFOX' . PHP_EOL . 'JUMPSOVERTHELAZYDOG' . PHP_EOL;
        $streamFileReaderMock = $this->getStreamFileReaderMock();
        $randomIntegerGeneratorMock = $this->getRandomIntegerGeneratorMock();

        $streamFileSampler = new StreamFileSampler($streamFileReaderMock, $randomIntegerGeneratorMock);

        $streamFileReaderMock->expects(static::exactly(2))
            ->method('getReadIterations')
            ->willReturn(5);

        $streamFileReaderMock->expects(static::exactly(6))
            ->method('read')
            ->willReturnOnConsecutiveCalls($chunk, $chunk, $chunk, $chunk, $chunk, false);

        $randomIntegerGeneratorMock->expects(static::once())
            ->method('generateBatch')
            ->with(5, 5)
            ->willReturn([0, 1, 2, 3, 4]);

        $randomIntegerGeneratorMock->expects(static::exactly(5))
            ->method('generate')
            ->with(34)
            ->willReturnOnConsecutiveCalls(0, 1, 2, 3, 4);

        $this->assertEquals('THEQU', $streamFileSampler->create(5));
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|RandomIntegerGenerator
     */
    protected function getRandomIntegerGeneratorMock()
    {
        return static::getMock(RandomIntegerGenerator::class);
    }
}