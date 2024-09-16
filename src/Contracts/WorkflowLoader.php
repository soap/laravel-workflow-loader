<?php

namespace Soap\WorkflowLoader\Contracts;

interface WorkflowLoader
{
    public function all(): array;

    public function load(string $workflowName): array;
}
