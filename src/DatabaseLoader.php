<?php

namespace Soap\WorkflowStorage;

use Soap\WorkflowStorage\Contracts\WorkflowLoader;

class DatabaseLoader implements WorkflowLoader
{
    public function load(string $workflowName): array
    {
        return [];
    }
}
