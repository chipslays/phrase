<?php

namespace Chipslays\Phrase\Engine;

use Chipslays\Phrase\Exceptions\PhraseException;

class JsonEngine extends AbstractEngine
{
    protected $localeFileExtension = 'json';

    /**
     * @param string $path
     * @return array
     *
     * @throws PhraseException
     */
    public function parseLocaleFile(string $path): array
    {
        if (!file_exists($path)) {
            throw new PhraseException("Locale file not found in path {$path}", 1);
        }

        return json_decode(file_get_contents($path), true);
    }
}