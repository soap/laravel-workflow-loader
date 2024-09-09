<?php

namespace Soap\WorkflowStorage\Contracts;

interface WorkflowLoader
{
    public function load(string $workflowName): array;
}
