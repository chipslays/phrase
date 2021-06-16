<?php

use Chipslays\Phrase\Phrase;
use Chipslays\Phrase\Engine\JsonEngine;
use Chipslays\Phrase\Engine\YamlEngine;
use PHPUnit\Framework\TestCase;

final class PhraseTest extends TestCase
{
    public function testJson()
    {
        $engine = new JsonEngine(__DIR__ . '/locales/json', 'en_US');
        $phrase = new Phrase($engine);

        $text = $phrase->get('hello', ['{name}' => "John Doe"]);

        $this->assertEquals('Hello John Doe!',  $text);
    }

    public function testYaml()
    {
        $engine = new YamlEngine(__DIR__ . '/locales/yaml', 'en_US');
        $phrase = new Phrase($engine);

        $text = $phrase->get('hello', ['{name}' => "John Doe"]);

        $this->assertEquals('Hello John Doe!',  $text);
    }

    // TODO: more test cases...
}