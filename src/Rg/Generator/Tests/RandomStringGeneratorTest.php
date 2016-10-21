<?php
use Rg\Generator\RandomStringGenerator;
use Rg\Generator\RandomIntegerGenerator;

class RandomStringGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param int $expectedLength
     * @param int $string
     *
     * @dataProvider sampleProvider
     */
    public function testCanGenerate($expectedLength, $string)
    {
        $this->assertEquals($expectedLength, strlen($string));
    }

    /**
     * @return array
     */
    public function sampleProvider()
    {
        $randomStringGenerator = new RandomStringGenerator(new RandomIntegerGenerator());

        return [
            [5, $randomStringGenerator->generate(5)],
            [10, $randomStringGenerator->generate(10)],
            [15, $randomStringGenerator->generate(15)],
            [20, $randomStringGenerator->generate(20)],
            [25, $randomStringGenerator->generate(25)],
        ];
    }
}
