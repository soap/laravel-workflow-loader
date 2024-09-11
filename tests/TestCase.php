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
        $this->artisan('vendor:publish --tag="workflow-storage-migrations"');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations'); // load the test migrations
        //$this->loadMigrationsFrom(__DIR__.'/../database/migrations'); // load the package migrations
    }

    protected function getPackageProviders($app)
    {
        return [
            WorkflowStorageServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {

        //include_once __DIR__.'/database/migrations/01_20240912_create_users_table.php';
        //(new \CreateUsersTable())->up();
        //include_once __DIR__.'/database/migrations/02_20240912_create_orders_table.php';
        //(new \CreateOrdersTable())->up();
    }
}
