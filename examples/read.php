<?php

require __DIR__ . '/../vendor/autoload.php';

$generator = new \ComposerJson\Generator();
$generator->read(__DIR__ . '/large.composer.json');

$array = $generator->toArray();
$json  = $generator->toJson();

//var_dump($array);
echo $json . PHP_EOL;
