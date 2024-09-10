<?php

namespace Soap\WorkflowStorage\Contracts;

interface WorkflowLoader
{
    public function load(string $workflowName): array;

    public function getWorkflowTableName(): string;

    public function getWorkflowStateTableName(): string;

    public function getWorkflowTransitionTableName(): string;

    public function getWorkflowStateTransitionTableName(): string;
}
