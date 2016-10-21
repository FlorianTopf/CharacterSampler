<?php
namespace Rg\Generator\Tests;

use Rg\Generator\RandomIntegerGenerator;

class RandomIntegerGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     * @param int $expectedMax
     * @param int $integer
     *
     * @dataProvider sampleProvider
     */
    public function testCanGenerate($expectedMax, $integer)
    {
        $this->assertLessThanOrEqual($expectedMax, $integer);
    }

    /**
     * @return array
     */
    public function sampleProvider()
    {
        $randomIntegerBatchGenerator = new RandomIntegerGenerator();

        return [
            [100, $randomIntegerBatchGenerator->generate(100)],
            [150, $randomIntegerBatchGenerator->generate(150)],
            [200, $randomIntegerBatchGenerator->generate(200)],
            [250, $randomIntegerBatchGenerator->generate(250)],
            [300, $randomIntegerBatchGenerator->generate(300)],
        ];
    }
}
