<?php
use Rg\Generator\RandomIntegerBatchGenerator;

class RandomIntegerBatchGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param int $expectedSize
     * @param int $expectedMax
     * @param int[] $batch
     *
     * @dataProvider sampleProvider
     */
    public function testCanGenerate($expectedSize, $expectedMax, $batch)
    {
        foreach ($batch as $integer) {
            $this->assertLessThanOrEqual($expectedMax, $integer);
        }
        $this->assertEquals($expectedSize, count($batch));
    }

    /**
     * @return array
     */
    public function sampleProvider()
    {
        $randomIntegerBatchGenerator = new RandomIntegerBatchGenerator();

        return [
            [10, 100, $randomIntegerBatchGenerator->generate(100, 10)],
            [20, 150, $randomIntegerBatchGenerator->generate(150, 20)],
            [30, 200, $randomIntegerBatchGenerator->generate(200, 30)],
            [40, 250, $randomIntegerBatchGenerator->generate(250, 40)],
            [50, 300, $randomIntegerBatchGenerator->generate(300, 50)],
        ];
    }
}
