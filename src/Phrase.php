<?php

namespace Chipslays\Phrase;

use Chipslays\Phrase\Engine\EngineInterface;
use Chipslays\Phrase\Exceptions\PhraseException;

/**
 * @method static string|array get(string $key, ?array $replace = null, ?string $locale = null)
 */
class Phrase
{
    protected static $engine;

    public function __construct(EngineInterface $engine)
    {
        self::$engine = $engine;
    }

    /**
     * @param EngineInterface $engine
     * @return void
     */
    public static function setEngine(EngineInterface $engine): void
    {
        self::$engine = $engine;
    }

    /**
     * @return boolean
     */
    public static function hasEngine(): bool
    {
        return self::$engine !== null;
    }

    /**
     * @param mixed $method
     * @param mixed $args
     * @return mixed
     *
     * @throws PhraseException
     */
    public function __call($method, $args)
    {
        return self::executeEngineMethod($method, $args);
    }

    /**
     * @param mixed $method
     * @param mixed $args
     * @return mixed
     *
     * @throws PhraseException
     */
    public static function __callStatic($method, $args)
    {
        return self::executeEngineMethod($method, $args);
    }

    /**
     * @param mixed $method
     * @param mixed $args
     * @return mixed
     *
     * @throws PhraseException
     */
    protected static function executeEngineMethod($method, $args)
    {
        if (!method_exists(self::$engine, $method)) {
            throw new PhraseException("Method `{$method}` not exists in Engine.", 1);
        }

        return call_user_func_array([self::$engine, $method], $args);
    }
}
