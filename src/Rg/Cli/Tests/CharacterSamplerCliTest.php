<?php
namespace Rg\Cli;

use Rg\Client\CurlClient;
use Rg\Generator\RandomIntegerGenerator;
use Rg\Generator\RandomStringGenerator;
use Rg\Reader\StreamFileReader;

class CharacterSamplerCliTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testCanGetFileSample()
    {
        $randomIntegerGenerator = new RandomIntegerGenerator();
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/sample.txt', 'r')),
            new CurlClient(),
            $randomIntegerGenerator,
            new RandomStringGenerator($randomIntegerGenerator)
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
        $randomIntegerGenerator = new RandomIntegerGenerator();
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/emptySample.txt', 'r')),
            new CurlClient(),
            $randomIntegerGenerator,
            new RandomStringGenerator($randomIntegerGenerator)
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
        $randomIntegerGenerator = new RandomIntegerGenerator();
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/emptySample.txt', 'r')),
            new CurlClient(),
            $randomIntegerGenerator,
            new RandomStringGenerator($randomIntegerGenerator)
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
        $randomIntegerGenerator = new RandomIntegerGenerator();
        $characterSamplerCli = new CharacterSamplerCli(
            new StreamFileReader(fopen(__DIR__ . '/mock/emptySample.txt', 'r')),
            new CurlClient(),
            $randomIntegerGenerator,
            new RandomStringGenerator($randomIntegerGenerator)
        );

        $sample = $characterSamplerCli->getSample([
            'size' => 'blablabla',
            'type' => 'impossible'
        ]);

        $this->assertEquals(5, strlen($sample));
    }
}
