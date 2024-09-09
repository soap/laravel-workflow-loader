<?php

namespace Soap\WorkflowStorage;

use Soap\WorkflowStorage\Commands\WorkflowStorageCommand;
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
                'create_workflows_table',
            ])
            ->hasCommand(WorkflowStorageCommand::class);
    }
}
