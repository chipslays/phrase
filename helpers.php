<?php

use Chipslays\Phrase\Phrase;
use Chipslays\Phrase\Exceptions\PhraseException;

if (! function_exists('__')) {
    /**
     * @param string $key
     * @param array|null $replace
     * @param string|null $locale
     * @return string|array
     *
     * @throws PhraseException
     */
    function __(string $key, ?array $replace = null, ?string $locale = null) {
        if (!Phrase::hasEngine()) {
            throw new PhraseException("Before use Phrase helper (".__FUNCTION__."), set any engine by `setEngine` method.", 1);
        }
        return Phrase::get($key, $replace, $locale);
    }
}