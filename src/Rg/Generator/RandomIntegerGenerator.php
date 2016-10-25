<?php
namespace Rg\Generator;

class RandomIntegerGenerator
{
    /**
     * @param int $maximum
     *
     * @return int
     */
    public function generate($maximum)
    {
        return random_int(0, $maximum);
    }

    /**
     * @param int $maximum
     * @param int $amount
     *
     * @return int[]
     */
    public function generateBatch($maximum, $amount)
    {
        $numbers = range(0, $maximum);
        $this->secureShuffle($numbers);

        return array_slice($numbers, 0, $amount);
    }

    /**
     * Shuffle an array using a CSPRNG
     *
     * @link https://paragonie.com/b/JvICXzh_jhLyt4y3
     *
     * @param &array $array reference to an array
     */
    protected function secureShuffle(&$array)
    {
        $size = count($array);
        $keys = array_keys($array);
        for ($i = $size - 1; $i > 0; --$i) {
            $r = random_int(0, $i);
            if ($r !== $i) {
                $temp = $array[$keys[$r]];
                $array[$keys[$r]] = $array[$keys[$i]];
                $array[$keys[$i]] = $temp;
            }
        }
        // resets indexes
        $array = array_values($array);
    }
}
