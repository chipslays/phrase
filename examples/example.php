<?php

use Chipslays\Phrase\Phrase;
use Chipslays\Phrase\Engine\JsonEngine;
use Chipslays\Phrase\Engine\YamlEngine;

require_once __DIR__ . '/../vendor/autoload.php';

// json
$engine = new JsonEngine(__DIR__ . '/locales/json', 'en_US');
$phrase = new Phrase($engine);

echo $phrase->get('hello', ['{name}' => "John Doe"]) . PHP_EOL;

echo Phrase::get('hello', ['{name}' => 'John Doe'], 'ru_RU') . PHP_EOL;

echo __('plural', ['{count}' => 1, '{money}' => 100]) . PHP_EOL;

print_r(__('array'));

// yaml
$engine = new YamlEngine(__DIR__ . '/locales/yaml', 'en_US');
Phrase::setEngine($engine);

echo $phrase->get('hello', ['{name}' => "John Doe"]) . PHP_EOL;

echo Phrase::get('hello', ['{name}' => 'John Doe'], 'ru_RU') . PHP_EOL;

echo __('plural', ['{count}' => 1, '{money}' => 100]) . PHP_EOL;

print_r(__('array'));


