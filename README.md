# Database Loader for Laravel workflow configuration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/soap/laravel-workflow-loader.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-workflow-loader)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/soap/laravel-workflow-loader/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/soap/laravel-workflow-loader/actions?query=workflow%3Arun-tests+branch%3Amain)
[![PHPStan](https://github.com/soap/laravel-workflow-loader/actions/workflows/phpstan.yml/badge.svg)](https://github.com/soap/laravel-workflow-loader/actions/workflows/phpstan.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/soap/laravel-workflow-loader/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/soap/laravel-workflow-loader/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/soap/laravel-workflow-loader.svg?style=flat-square)](https://packagist.org/packages/soap/laravel-workflow-loader)

This package extends [zerodahero/laravel-workflow](https://github.com/zerodahero/laravel-workflow) by adding option to store workflow configuration in database. Laravel workflow only support loading configuration form Laravel configuration. This package provides user to change workflow configuration without helping from developers. 

## Support us
You can suggest for any approvement, sponsor this project or make a pull request. I am happy to consider any recommendation. I am not a good programmer so my design may not be the best one. My background is not computer programming. I am an Electrical engineer.

## Installation

You can install the package via composer:

```bash
composer require soap/laravel-workflow-loader
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="workflow-loader-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="workflow-loader-config"
```

This is the contents of the published config file:

```php
return [
    'loaders' => [
        'database' => [
            'tableNames' => [
                'workflows' => 'workflows',
                'workflow_states' => 'workflow_states',
                'workflow_transitions' => 'workflow_transitions',
                'workflow_state_transitions' => 'workflow_state_transitions',
            ],
            'class' => \Soap\WorkflowLoader\DatabaseLoader::class,
        ],
    ],
];
```

To use this package to load workflow configuration from database, you need to register workflow service provider provided by the package. Zerodahero 's workflow registry will be used to load configuration retreiving from database. 
```
php artisan venodr:publish --tag="workflow-loader-provider"
```

This will copy the following WorkflowServiceProvider.php to application providers folder, ensure that it was included in application bootstrap. The following is the content of the file.

```php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WorkflowServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot()
    {
        $registry = app()->make('workflow');
        $workflowLoaderRegistry = app()->make('workflowLoaderRegistry');   
        foreach ($workflowLoaderRegistry->all() as $workflow => $config) {
            $registry->addFromArray($workflow, $config);
        }
    }
}
```
This package doesnot provide user interface for user to manage workflow configuration. By design it should be in separate package. I have a plan to create filament plugin to handle this.

## Usage
After you have completed setup, create workflow configuration in database using your own way or provided by other package. Then use them like the one you use by zerohadero/laravel-workflow. Storing configuration in database is easy to develop workflow for user.

## To Do
Curently guards should be created via event subscriber. I have a plan to use Symfony expression as upper guard layer. For example, you can write;

```
guard => $subject.isWaitingFor($user) || !$subject.isOwnedBy($user)
```
or 
```
guard => $subject.isApprovers($user) || $subject.isReviewers($user)
```
Then the package will inject $subject and $user for you and use Symfony expression to evaluate blocking of the transition.

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
