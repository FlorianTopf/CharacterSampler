<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Rg\Reader\StreamFileReader;
use Rg\Client\CurlClient;
use Rg\Generator\RandomIntegerGenerator;
use Rg\Generator\RandomIntegerBatchGenerator;
use Rg\Generator\RandomStringGenerator;
use Rg\Cli\CharacterSamplerCli;

$before = memory_get_usage();

$randomIntegerGenerator = new RandomIntegerGenerator();
$characterSamplerCli = new CharacterSamplerCli(
    new StreamFileReader(STDIN),
    new CurlClient(),
    $randomIntegerGenerator,
    new RandomStringGenerator($randomIntegerGenerator)
);

if ($sample = $characterSamplerCli->getSample()) {
    echo 'Random Sample: ' . $sample . PHP_EOL;
}

$after = memory_get_usage() . PHP_EOL;

echo 'Maximum allocated memory during runtime: ' . ($after - $before)/(1024*1024) . ' MB' . PHP_EOL;
