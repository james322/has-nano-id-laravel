# This is my package has-nano-id-laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/james322/has-nano-id-laravel.svg?style=flat-square)](https://packagist.org/packages/james322/has-nano-id-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/james322/has-nano-id-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/james322/has-nano-id-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/james322/has-nano-id-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/james322/has-nano-id-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/james322/has-nano-id-laravel.svg?style=flat-square)](https://packagist.org/packages/james322/has-nano-id-laravel)

A php trait to add [Nano IDs](https://github.com/ai/nanoid) to Laravel models.

## Installation

You can install the package via composer:

```bash
composer require james322/has-nano-id-laravel
```

Publish the config file with:

```bash
php artisan vendor:publish --tag="has-nano-id-laravel-config"
```

This is the contents of the published config file:

```php
return [

    'alphabet' => env('NANO_ID_ALPHABET', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz-'),

    'size' => (int) env('NANO_ID_SIZE', 21)
];
```


## Usage
In your model import the trait and add the column to your database table you wish to use for the Nano ID.

```php
use james322\HasNanoId\HasNanoId;

class User
{
    use HasNanoId;
}
```
Now when the model is created for the first time a Nano ID will be generated.

The database column used for storing the Nano ID can be customized by adding a $nano_id_key property on your model.

```php
use james322\HasNanoId\HasNanoId;

class User
{
    use HasNanoId;

    public $nano_id_key = 'custom_column'; // default 'public_key'
}
```

The default alphabet and size (length) of the nano id can be customized in the nano-id.php config file. You can also customize it on a per model basis by adding $nano_id_alphabet and $nano_id_size property to your model.

```php
use james322\HasNanoId\HasNanoId;

class User
{
    use HasNanoId;

    public $nano_id_alphabet = 'abcdefg1234567890-'; // default '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz-'

    public $nano_id_size = 14; // default 21
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
