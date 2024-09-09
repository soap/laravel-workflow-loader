<?php

namespace Soap\WorkflowStorage;

use Soap\WorkflowStorage\Contracts\WorkflowLoader;

class WorkflowStorage
{
    protected array $loaders = [];

    public function registerLoader(WorkflowLoader $loader)
    {
        $this->loaders[$loader::class] = $loader;
    }
}
