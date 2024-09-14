<?php

namespace Soap\WorkflowStorage;

use Soap\WorkflowStorage\Contracts\WorkflowStorage as WorkflowStorageContract;

class WorkflowStorage
{
    protected array $loaders = [];

    public function __construct(?WorkflowStorageContract $loader)
    {
        if ($loader) {
            $this->registerLoader($loader);
        }
    }

    public function registerLoader(WorkflowStorageContract $loader)
    {
        $this->loaders[$loader::class] = $loader;
    }

    public function getLoader(string $loader): WorkflowStorageContract
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
