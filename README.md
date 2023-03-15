# Enchant Spellchecking Library

Hunspell based spellchecking library for PHP.

The Library is [PSR-1](https://www.php-fig.org/psr/psr-1/), [PSR-4](https://www.php-fig.org/psr/psr-4/), [PSR-12](https://www.php-fig.org/psr/psr-12/) compliant.

## Requirements

- `>= PHP 7.2`

## Dependencies

- ext-enchant

## Install

```
composer require typomedia/enchant
```

## Usage

```php
use Typomedia\Enchant\Enchant;

$enchant = new Enchant();

$results = $enchant->getSuggestions('en_US', 'experiance');

var_dump($results);

//array(2) {
//  [0]=> string(10) "experience"
//  [1]=> string(10) "Spencerian"
//}
```
