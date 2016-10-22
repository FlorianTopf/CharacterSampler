<?php
namespace Rg\Reader\Tests;

use Rg\Reader\StreamFileReader;

class StreamFileReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCanRead()
    {
        $resource = fopen(__DIR__ . '/mock/sample.txt', 'r');
        $expectedChunk = fopen(__DIR__ . '/mock/expectedChunk.txt', 'r');
        $streamFileReader = new StreamFileReader($resource);
        $this->assertEquals(108279, $streamFileReader->getFileSize());
        $this->assertEquals(105, $streamFileReader->getReadIterations());
        $this->assertEquals(fread($expectedChunk, 1024), $streamFileReader->read());
    }
}