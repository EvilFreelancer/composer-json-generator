<?php

require __DIR__ . '/../vendor/autoload.php';

use \ComposerJson\Generator;
use \ComposerJson\Schemas\Composer;
use \ComposerJson\Schemas\Author;
use \ComposerJson\Schemas\Repository;
use \ComposerJson\Schemas\Psr4;

// Initial the generator
$generator = new Generator();

// Initiate composer object
$composer = new Composer();

/*
 * Set basic parameters of new composer.json file
 */

$composer->name        = 'evilfreelancer/composer-json-generator';
$composer->type        = 'library';
$composer->description = 'Small library for generating composer.json file with validation by composer\'s schema';
$composer->keywords    = ['composer', 'json', 'generator'];
$composer->license     = 'MIT';

/*
 * Autoloader details
 */

// For normal usage
$psr4 = new Psr4();

$psr4->options = [
    "ComposerJson\\" => './src/',
];

$composer->autoload[] = $psr4;

// For tests
$psr4 = new Psr4();

$psr4->options = [
    "ComposerJson\\Tests\\" => './tests/',
];

$composer->autoloadDev[] = $psr4;

/*
 * Authors of project
 */

$author           = new Author();
$author->name     = 'Paul Rock';
$author->email    = 'paul@drteam.rocks';
$author->homepage = 'https://twitter.com/EvilFreelancer';
$author->role     = 'Developer';

$composer->authors[] = $author;

/*
 * Require rules
 */

$composer->require = [
    'php'      => '^7.4',
    'ext-json' => '*'
];

$composer->requireDev = [
    'phpunit/phpunit' => '^8.0',
];

/*
 * Load composer into the generator
 */

$generator->load($composer);

/*
 * Generate result
 */

$array = $generator->toArray();
$json  = $generator->toJson();

//var_dump($array);
echo $json . PHP_EOL;
