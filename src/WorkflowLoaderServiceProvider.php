<?php

namespace Soap\WorkflowLoader;

use Soap\WorkflowLoader\Commands\WorkflowLoaderListCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WorkflowLoaderServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-workflow-loader')
            ->hasConfigFile('workflow_loader')
            ->hasMigrations([
                'wf1_create_workflows_table',
                'wf2_create_workflow_states_table',
                'wf3_create_workflow_transitions_table',
                'wf4_create_workflow_state_transitions_table',
            ])
            ->hasCommand(WorkflowLoaderListCommand::class)
            ->publishesServiceProvider('WorkflowServiceProvider');
    }

    public function packageRegistered()
    {
        $this->app->when(\Soap\WorkflowLoader\DatabaseLoader::class)
            ->needs('$config')
            ->give($this->app->make('config')->get('workflow_loader.loaders.database'));

        $this->app->when(\Soap\WorkflowLoader\WorkflowLoaderRegistry::class)
            ->needs('$loaders')
            ->give($this->app->make('config')->get('workflow_loader.loaders'));

        $this->app->bind(\Soap\WorkflowLoader\Contracts\WorkflowDatabaseLoader::class, \Soap\WorkflowLoader\DatabaseLoader::class);

        $this->app->singleton('workflowLoaderRegistry', \Soap\WorkflowLoader\WorkflowLoaderRegistry::class);
    }
}
