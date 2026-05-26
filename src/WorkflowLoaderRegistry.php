<?php

namespace Soap\WorkflowLoader;

use Soap\WorkflowLoader\Contracts\WorkflowLoader as WorkflowLoaderContract;

class WorkflowLoaderRegistry
{
    protected array $loaders = [];

    public function __construct(array $loaders)
    {
        foreach ($loaders as $key => $loader) {
            if (! isset($loader['class'])) {
                throw new \InvalidArgumentException("Loader [{$key}] is missing the required 'class' key in workflow_loader config.");
            }

            if (! class_exists($loader['class'])) {
                throw new \InvalidArgumentException("Loader [{$key}] references a class that does not exist. Check workflow_loader config.");
            }

            $this->registerLoader($key, app()->make($loader['class']));
        }
    }

    public function registerLoader(string $name, WorkflowLoaderContract $loader)
    {
        $this->loaders[$name] = $loader;
    }

    public function getLoaders(): array
    {
        return $this->loaders;
    }

    public function getLoader(string $name): WorkflowLoaderContract
    {
        if (! isset($this->loaders[$name])) {
            throw new \Exception("Loader {$name} not found");
        }

        return $this->loaders[$name];
    }

    public function all(): array
    {
        if (\count($this->loaders) === 0) {
            return [];
        }

        return cache()->remember('workflow_loader.registry.all', 3600, function () {
            $workflows = [];
            foreach ($this->loaders as $loader) {
                foreach ($loader->all() as $workflow => $config) {
                    $workflows[$workflow] = $config;
                }
            }

            return $workflows;
        });
    }

    public function flushCache(): void
    {
        cache()->forget('workflow_loader.registry.all');
    }
}
