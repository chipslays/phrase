<?php

namespace Chipslays\Phrase\Engine;

use Chipslays\Phrase\Exceptions\PhraseException;

interface EngineInterface
{
    /**
     * @param string $key
     * @param array|null $replace
     * @param string|null $locale
     * @return string|array
     *
     * @throws PhraseException
     */
    public function get(string $key, ?array $replace = null, ?string $locale = null);
}
