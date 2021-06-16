<?php

namespace Chipslays\Phrase\Engine;

use Chipslays\Phrase\Plural;
use Chipslays\Phrase\Exceptions\PhraseException;

abstract class AbstractEngine implements EngineInterface
{
    protected string $root;
    protected string $locale;
    protected ?string $fallback;

    protected array $locales = [];

    public function __construct(
        string $root = 'locales',
        string $locale = 'en_US',
        ?string $fallback = null
    ) {
        $this->root = rtrim($root, '\\/');
        $this->locale = $locale;
        $this->fallback = $fallback ?? $locale;
    }

    abstract protected function load(string $locale): void;

    private function loadLocaleIfNotLoaded(string $locale): void
    {
        if (!isset($this->locales[$locale])) {
            $this->load($locale);
        }
    }

    private function loadFallbackIfNotLoaded(): void
    {
        if (!isset($this->locales[$this->fallback])) {
            $this->load($this->fallback);
        }
    }

    protected function getMessageByKey(string $key, string $locale)
    {
        $this->loadLocaleIfNotLoaded($locale);
        if (isset($this->locales[$locale][$key])) {
            return $this->locales[$locale][$key];
        }

        $this->loadFallbackIfNotLoaded();
        if (isset($this->locales[$this->fallback][$key])) {
            return $this->locales[$this->fallback][$key];
        }

        throw new PhraseException("Key `{$key}` not exists in `{$locale}` locale and in {$this->fallback} fallback. ", 1);
    }

    /**
     * @param string $key
     * @param array|null $replace
     * @param string|null $locale
     * @return string|array
     *
     * @throws PhraseException
     */
    public function get(string $key, ?array $replace = null, ?string $locale = null)
    {
        $text = $this->getMessageByKey($key, $locale ?? $this->locale);

        if ($replace) {
            $text = strtr($text, $replace);
        }

        if (is_string($text) && preg_match_all('/{{rus:(.*?)}}/u', $text, $matches)) {
            foreach ($matches[1] as $index => $value) {
                $forms = explode(',', $value);
                $form = Plural::rus(array_shift($forms), $forms);
                $text = str_replace($matches[0][$index], $form, $text);
            }
        }

        $matches = null;

        if (is_string($text) && preg_match_all('/{{eng:(.*?)}}/u', $text, $matches)) {
            foreach ($matches[1] as $index => $value) {
                $forms = explode(',', $value);
                $form = Plural::eng(array_shift($forms), $forms[0]);
                $text = str_replace($matches[0][$index], $form, $text);
            }
        }

        return $text;
    }
}
