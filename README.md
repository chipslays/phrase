# 🙊 Phrase

![GitHub Workflow Status](https://img.shields.io/github/workflow/status/chipslays/phrase/tests)
![Packagist Version](https://img.shields.io/packagist/v/chipslays/phrase)
![GitHub](https://img.shields.io/github/license/chipslays/phrase?color=%23a6957c)

Internationalization library for PHP.

## Features
* Translations based on [`JSON`](examples/locales/json), [`YAML`](examples/locales/yaml) files;
* Easy addition of new [sources files](src/Engine);
* Interpolated translations;
* Pluralization;

## Installation

```bash
composer require chopslays/phrase
```

## Setup

Locale file: `locales/yaml/en_US.yml`
```yaml
# interpolated message
hello: Hello {name}!

# pluralization
plural: I have {count} {{eng:{count},melon}} and {money} {{eng:{money},dollar}}.

# message can be a array
array:
  text: This is my flag.
  image: images/en-flag.jpg
  myKey: myValue
```

Locale file: `locales/json/en_US.json`
```json
{
    "hello": "Hello {name}!",
    "plural": "I have {count} {{eng:{count},melon}} and {money} {{eng:{money},dollar}}.",
    "array": {
        "text": "This is my flag.",
        "image": "images/en-flag.jpg"
    }
}
```

## Usage

### Create `Phrase` instance

```php
use Chipslays\Phrase\Phrase;
use Chipslays\Phrase\Engine\JsonEngine;

$engine = new JsonEngine(__DIR__ . '/locales/json', 'en_US');
$phrase = new Phrase($engine);
$phrase->get(...);
```

```php
use Chipslays\Phrase\Phrase;
use Chipslays\Phrase\Engine\YamlEngine;

$engine = new YamlEngine(__DIR__ . '/locales/yaml', 'en_US');
$phrase = new Phrase($engine);
$phrase->get(...);
```

```php
use Chipslays\Phrase\Phrase;
use Chipslays\Phrase\Engine\JsonEngine;

$engine = new JsonEngine(__DIR__ . '/locales/json', 'en_US');
Phrase::setEngine($engine);
Phrase::get(...);
```

### Get message

```php
$phrase->get('hello');
Phrase::get('hello');
__('hello');
```

Pass language code for force use.

```php
$phrase->get('hello', null, 'ru_RU');
Phrase::get('hello', null, 'ru_RU');
__('hello', null, 'ru_RU');
```

### Interpolation

Pass named arguments to interpolate your translations.

```php
$phrase->get('hello', ['{name}' => 'John Doe']);
Phrase::get('hello', ['{name}' => 'John Doe']);
__('hello', ['{name}' => 'John Doe']);

// Hello John Doe!
```

### Pluralization

English pluralization phrase:
```
{{eng:{count},melon}}
```

Russian pluralization phrase:
```
{{rus:{count},арбуз,арбуза,арбузов}}
```

```yaml
# english locale file
# for english plural word have 1 form
...
plural: I have {count} {{eng:{count},melon}} and {money} {{eng:{money},dollar}}.
....
```

```yaml
# russian locale file
# for russian plural word have 3 forms
...
plural: У меня есть {count} {{rus:{count},арбуз,арбуза,арбузов}} и {money} {{rus:{money},рубль,рубля,рублей}}
....
```

```php
$phrase->get('plural', ['{count}' => 1, '{money}' => 100])
Phrase::get('plural', ['{count}' => 1, '{money}' => 100])
__('plural', ['{count}' => 1, '{money}' => 100])

// I have 1 melon and 100 dollars.
```

```php
use Chipslays\Phrase\Plural;

echo Plural::eng(10, 'melon'); // melons
echo Plural::rus(10, ['арбуз', 'арбуза', 'арбузов']); // арбузов
```

### Helpers
```php
__(string $key, ?array $replace = null, ?string $locale = null): string|array
```

```php
__('hello', ['{name}' => 'John Doe'], 'en_US');
```

### Custom locale file (Engine)

Example for `YamlEngine`:

```php
use Chipslays\Phrase\Engine\AbstractEngine;
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
```

## License
MIT
