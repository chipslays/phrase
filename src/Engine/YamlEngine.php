<?php

namespace Chipslays\Phrase\Engine;

use Chipslays\Phrase\Exceptions\PhraseException;

class YamlEngine extends AbstractEngine
{
    /**
     * @param string $locale
     * @return void
     *
     * @throws PhraseException
     */
    protected function load(string $locale): void
    {
        $path = $this->root . '/' . $locale . '.yml';

        if (!file_exists($path)) {
            throw new PhraseException("Locale file not found in path {$path}", 1);
        }

        $this->locales[$locale] = yaml_parse_file($path);
    }
}
