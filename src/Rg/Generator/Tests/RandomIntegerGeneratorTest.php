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

    /**
     * @test
     *
     * @param int $expectedSize
     * @param int $expectedMax
     * @param int[] $batch
     *
     * @dataProvider sampleBatchProvider
     */
    public function testCanGenerateBatch($expectedSize, $expectedMax, $batch)
    {
        foreach ($batch as $integer) {
            $this->assertLessThanOrEqual($expectedMax, $integer);
        }
        $this->assertEquals($expectedSize, count($batch));
    }

    /**
     * @return array
     */
    public function sampleBatchProvider()
    {
        $randomIntegerBatchGenerator = new RandomIntegerGenerator();

        return [
            [10, 100, $randomIntegerBatchGenerator->generateBatch(100, 10)],
            [20, 150, $randomIntegerBatchGenerator->generateBatch(150, 20)],
            [30, 200, $randomIntegerBatchGenerator->generateBatch(200, 30)],
            [40, 250, $randomIntegerBatchGenerator->generateBatch(250, 40)],
            [50, 300, $randomIntegerBatchGenerator->generateBatch(300, 50)],
        ];
    }
}
