<?php

namespace Soap\WorkflowLoader;

use Soap\WorkflowLoader\Commands\WorkflowLoaderListCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WorkflowLoaderServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
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
        // Register DatabaseLoader with safe config retrieval
        $this->app->singleton(DatabaseLoader::class, function ($app) {
            $config = $app['config']->get('workflow_loader.loaders.database', []);

            // Provide default config if not found
            if (empty($config) || ! isset($config['tableNames'])) {
                $config = [
                    'tableNames' => [
                        'workflows' => 'workflows',
                        'workflow_states' => 'workflow_states',
                        'workflow_transitions' => 'workflow_transitions',
                        'workflow_state_transitions' => 'workflow_state_transitions',
                    ],
                ];
            }

            return new DatabaseLoader(
                $config,
                $app->make(Repositories\WorkflowRepository::class)
            );
        });

        // Register WorkflowLoaderRegistry
        $this->app->singleton(WorkflowLoaderRegistry::class, function ($app) {
            $loaders = $app['config']->get('workflow_loader.loaders', []);

            return new WorkflowLoaderRegistry($loaders);
        });

        // Bind contracts
        $this->app->bind(
            Contracts\WorkflowDatabaseLoader::class,
            DatabaseLoader::class
        );

        $this->app->singleton('workflowLoaderRegistry', WorkflowLoaderRegistry::class);
    }
}
