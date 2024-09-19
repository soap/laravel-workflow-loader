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
                throw new \Exception("Key 'class' configuration not found in {$key} loader");
            }

            if (! class_exists($loader['class'])) {
                throw new \Exception("Class {$loader['class']} not found");
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
        if (count($this->loaders) === 0) {
            return [];
        }

        $workflows = [];
        foreach ($this->loaders as $name => $loader) {
            foreach ($loader->all() as $workflow => $config) {
                $workflows[$workflow] = $config;
            }
        }

        return $workflows;
    }
}
