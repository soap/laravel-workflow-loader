<?php

namespace Soap\WorkflowLoader\Contracts;

interface WorkflowDatabaseLoader extends WorkflowLoader
{
    public function getWorkflowTableName(): string;

    public function getWorkflowStateTableName(): string;

    public function getWorkflowTransitionTableName(): string;

    public function getWorkflowStateTransitionTableName(): string;
}
