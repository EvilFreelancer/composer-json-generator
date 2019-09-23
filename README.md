[![Latest Stable Version](https://poser.pugx.org/evilfreelancer/composer-json-generator/v/stable)](https://packagist.org/packages/evilfreelancer/composer-json-generator)
[![Build Status](https://travis-ci.org/EvilFreelancer/composer-json-generator.svg?branch=master)](https://travis-ci.org/EvilFreelancer/composer-json-generator)
[![Total Downloads](https://poser.pugx.org/evilfreelancer/composer-json-generator/downloads)](https://packagist.org/packages/evilfreelancer/composer-json-generator)
[![License](https://poser.pugx.org/evilfreelancer/composer-json-generator/license)](https://packagist.org/packages/evilfreelancer/composer-json-generator)
[![Code Climate](https://codeclimate.com/github/EvilFreelancer/composer-json-generator/badges/gpa.svg)](https://codeclimate.com/github/EvilFreelancer/composer-json-generator)
[![Code Coverage](https://scrutinizer-ci.com/g/EvilFreelancer/composer-json-generator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/EvilFreelancer/composer-json-generator/?branch=master)
[![Scrutinizer CQ](https://scrutinizer-ci.com/g/evilfreelancer/composer-json-generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/evilfreelancer/composer-json-generator/)

# Composer JSON generator

Small **PHP 7.4** library for generating composer.json file with validation by composer's schema

    composer require evilfreelancer/composer-json-generator

Project inspired by [spatie/schema-org](https://github.com/spatie/schema-org).

# How to use

All available examples is [here](examples).

## Create new _composer.json_ file in OOP style

```php
require __DIR__ . '/vendor/autoload.php';

use \ComposerJson\Generator;
use \ComposerJson\Schemas\Composer;
use \ComposerJson\Schemas\Author;
use \ComposerJson\Schemas\Psr4;

// Initiate generator
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

var_dump($array);
echo $json . PHP_EOL;
```

Results is

```json
{
    "name": "evilfreelancer/composer-json-generator",
    "description": "Small library for generating composer.json file with validation by composer's schema",
    "type": "library",
    "keywords": [
        "composer",
        "json",
        "generator"
    ],
    "license": "MIT",
    "authors": [
        {
            "name": "Paul Rock",
            "email": "paul@drteam.rocks",
            "homepage": "https://twitter.com/EvilFreelancer",
            "role": "Developer"
        }
    ],
    "require": {
        "php": "^7.4",
        "ext-json": "*"
    },
    "require-dev": {
        "phpunit/phpunit": "^8.0"
    },
    "autoload": {
        "psr-4": {
            "ComposerJson\\": "./src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "ComposerJson\\Tests\\": "./tests/"
        }
    }
}
```

Btw, it used in current project.

## Read existing _composer.json_ file

```php
require __DIR__ . '/vendor/autoload.php';

use \ComposerJson\Generator;

$generator = new Generator();
$generator->read(__DIR__ . '/composer.json');

$array = $generator->toArray();
$json  = $generator->toJson();

//var_dump($array);
echo $json . PHP_EOL;
```

# Links

* https://getcomposer.org/doc/04-schema.md
* https://github.com/spatie/schema-org - My project inspired by this library
