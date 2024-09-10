<?php

namespace Soap\WorkflowStorage\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase as Orchestra;
use Soap\WorkflowStorage\WorkflowStorageServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            if (Str::startsWith($modelName, 'Soap\\WorkflowStorage\\Tests\\Models\\')) {
                // Factories within the tests directory
                return 'Soap\\WorkflowStorage\\Tests\\Database\\Factories\\'.class_basename($modelName).'Factory';
            }

            // Factories within the package directory
            return 'Soap\\WorkflowStorage\\Database\\Factories\\'.class_basename($modelName).'Factory';

        });

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations'); // load the package migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations'); // load the test migrations
    }

    protected function getPackageProviders($app)
    {
        return [
            WorkflowStorageServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

    }
}
