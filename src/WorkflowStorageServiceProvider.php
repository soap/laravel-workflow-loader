<?php

namespace Soap\WorkflowStorage;

use Soap\WorkflowStorage\Commands\WorkflowStorageListCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WorkflowStorageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-workflow-storage')
            ->hasConfigFile()
            ->hasMigrations([
                'wf1_create_workflows_table',
                'wf2_create_workflow_states_table',
                'wf3_create_workflow_transitions_table',
                'wf4_create_workflow_state_transitions_table',
            ])
            ->hasCommand(WorkflowStorageListCommand::class)
            ->publishesServiceProvider(WorkflowServiceProvider::class);
    }

    public function packageRegistered()
    {
        $this->app->singleton('workflow-storage', function ($app) {
            $workflowStorage = new WorkflowStorage($app->make(DatabaseLoader::class));
        });

        $this->app->singleton(DatabaseLoader::class, function ($app) {
            $config = $app->make('config')->get('workflow-storage.databaseLoader', []);

            return new DatabaseLoader(config: $config);
        });

    }
}
