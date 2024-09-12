<?php

namespace Soap\WorkflowStorage\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;
use Soap\WorkflowStorage\WorkflowStorageServiceProvider;

use function Orchestra\Testbench\workbench_path;

class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(function (string $modelName) {
            if (Str::startsWith($modelName, 'Workbench\\App\\Models\\')) {
                // Factories within the tests directory
                return 'Workbench\\Database\\Factories\\'.class_basename($modelName).'Factory';
            }

            // Factories within the package directory
            return 'Soap\\WorkflowStorage\\Database\\Factories\\'.class_basename($modelName).'Factory';

        });
        //$this->artisan('vendor:publish --tag="workflow-storage-migrations"');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations'); // load the package migrations
    }

    protected function getPackageProviders($app)
    {
        return [
            WorkflowStorageServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        dd($app->environment());
        /*
        $workflowTableMigration = require __DIR__.'/../database/migrations/create_workflows_table.php';
        $workflowTableMigration->up();

        $stateTableMigration = require __DIR__.'/../database/migrations/create_workflow_states_table.php';
        $stateTableMigration->up();

        $transitionTableMigration = require __DIR__.'/../database/migrations/create_workflow_transitions_table.php';
        $transitionTableMigration->up();

        $stateTransitionTableMigration = require __DIR__.'/../database/migrations/create_workflow_state_transitions_table.php';
        $stateTransitionTableMigration->up();
        */
    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(
            workbench_path('database/migrations')
        );
    }
}
