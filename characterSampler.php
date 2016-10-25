<?php
require_once(__DIR__ . '/vendor/autoload.php');

use Rg\Reader\StreamFileReader;
use Rg\Generator\RandomIntegerGenerator;
use Rg\Cli\CharacterSamplerCli;

$before = memory_get_usage();

$randomIntegerGenerator = new RandomIntegerGenerator();
$characterSamplerCli = new CharacterSamplerCli(new StreamFileReader(STDIN));

$cliArguments = getopt('', ['size:', 'type:']);

if ($sample = $characterSamplerCli->getSample($cliArguments)) {
    echo 'Random Sample: ' . $sample . PHP_EOL;
}

$after = memory_get_usage() . PHP_EOL;

echo 'Maximum allocated memory during runtime: ' . ($after - $before)/(1024*1024) . ' MB' . PHP_EOL;
