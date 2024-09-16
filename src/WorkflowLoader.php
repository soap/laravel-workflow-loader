<?php

namespace Soap\WorkflowLoader;

use Soap\WorkflowLoader\Contracts\WorkflowLoader as WorkflowLoaderContract;

class WorkflowLoader
{
    protected array $loaders = [];

    public function __construct(?WorkflowLoaderContract $loader)
    {
        if ($loader) {
            $this->registerLoader($loader);
        }
    }

    public function registerLoader(WorkflowLoaderContract $loader)
    {
        $this->loaders[$loader::class] = $loader;
    }

    public function getLoader(string $loader): WorkflowLoaderContract
    {
        return $this->loaders[$loader];
    }

    public function all(): array
    {
        if (count($this->loaders) === 0) {
            return [];
        }

        return collect($this->loaders)->mapWithKeys(function ($loader) {
            return [$loader::class => $loader->all()];
        })->toArray();
    }
}
