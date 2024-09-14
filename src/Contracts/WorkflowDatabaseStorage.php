<?php

namespace Soap\WorkflowStorage\Contracts;

interface WorkflowDatabaseStorage extends WorkflowStorage
{
    public function getWorkflowTableName(): string;

    public function getWorkflowStateTableName(): string;

    public function getWorkflowTransitionTableName(): string;

    public function getWorkflowStateTransitionTableName(): string;
}
