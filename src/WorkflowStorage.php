<?php

namespace Soap\WorkflowStorage;

use Soap\WorkflowStorage\Contracts\WorkflowLoader;

class WorkflowStorage
{
    protected array $loaders = [];

    public function __construct(?WorkflowLoader $loader)
    {
        if ($loader) {
            $this->registerLoader($loader);
        }
    }

    public function registerLoader(WorkflowLoader $loader)
    {
        $this->loaders[$loader::class] = $loader;
    }

    public function getLoader(string $loader): WorkflowLoader
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
