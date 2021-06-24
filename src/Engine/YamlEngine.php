<?php

namespace Chipslays\Phrase\Engine;

use Chipslays\Phrase\Exceptions\PhraseException;

class YamlEngine extends AbstractEngine
{
    protected $localeFileExtension = 'yml';

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

        return yaml_parse_file($path);
    }
}
