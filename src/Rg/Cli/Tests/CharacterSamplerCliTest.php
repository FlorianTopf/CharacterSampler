<?php
namespace Rg\Cli;

use Rg\Reader\StreamFileReader;

class CharacterSamplerCliTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCanGetFileSample()
    {
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/sample.txt', 'r'))
        );

        $sample = $characterSamplerCli->getSample([
            'size' => '10'
        ]);

        $this->assertEquals(10, strlen($sample));
    }

    /**
     * @test
     */
    public function testCanGetLocalSample()
    {
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/emptySample.txt', 'r'))
        );

        $sample = $characterSamplerCli->getSample([
            'size' => '10',
            'type' => 'local'
        ]);

        $this->assertEquals(10, strlen($sample));
    }

    /**
     * @test
     */
    public function testCanGetRemoteSample()
    {
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/emptySample.txt', 'r'))
        );

        $sample = $characterSamplerCli->getSample([
            'size' => '10',
            'type' => 'remote'
        ]);

        $this->assertEquals(10, strlen($sample));
    }

    /**
     * @test
     */
    public function testCanGetBaseSampleWithWrongArguments()
    {
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/emptySample.txt', 'r'))
        );

        $sample = $characterSamplerCli->getSample([
            'size' => 'blablabla',
            'type' => 'impossible'
        ]);

        $this->assertEquals(5, strlen($sample));
    }
}
