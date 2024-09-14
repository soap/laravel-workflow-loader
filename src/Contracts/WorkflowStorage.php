<?php

namespace Soap\WorkflowStorage\Contracts;

interface WorkflowStorage
{
    public function all(): array;

    public function load(string $workflowName): array;
}
