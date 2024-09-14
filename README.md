# Database storage for Laravel workflow configuration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/soap/laravel-workflow-storage.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-workflow-storage)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/soap/laravel-workflow-storage/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/soap/laravel-workflow-storage/actions?query=workflow%3Arun-tests+branch%3Amain)
[![PHPStan](https://github.com/soap/laravel-workflow-storage/actions/workflows/phpstan.yml/badge.svg)](https://github.com/soap/laravel-workflow-storage/actions/workflows/phpstan.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/soap/laravel-workflow-storage/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/soap/laravel-workflow-storage/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/soap/laravel-workflow-storage.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-workflow-storage)

This package extends [zerodahero/laravel-workflow](https://github.com/zerodahero/laravel-workflow) by adding option to store workflow configuration in database. Laravel workflow only support loading configuration form Laravel configuration. This package provides user to change workflow configuration without helping from developers. 

## Support us


## Installation

You can install the package via composer:

```bash
composer require soap/laravel-workflow-storage
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="workflow-storage-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="workflow-storage-config"
```

This is the contents of the published config file:

```php
return [
];
```


## Usage

To use this package to store workflow configuration you need to register workflow binding in your application service provider. You have to instruct Laravel to use new 'workflow' binding instead of the one provided by zerodahero/laravel-workflow.

```php

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Prasit Gebsaap](https://github.com/soap)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
