<?php

namespace Chipslays\Phrase\Engine;

use Chipslays\Phrase\Exceptions\PhraseException;

class JsonEngine extends AbstractEngine
{
    /**
     * @param string $locale
     * @return void
     *
     * @throws PhraseException
     */
    protected function load(string $locale): void
    {
        $path = $this->root . '/' . $locale . '.json';

        if (!file_exists($path)) {
            throw new PhraseException("Locale file not found in path {$path}", 1);
        }

        $raw = file_get_contents($path);
        $this->locales[$locale] = json_decode($raw, true);
    }
}
