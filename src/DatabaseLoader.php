<?php

namespace Soap\WorkflowStorage;

use Soap\WorkflowStorage\Contracts\WorkflowLoader;

class DatabaseLoader implements WorkflowLoader
{
    const KEY_TABLENAMES = 'tableNames';

    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getTableNames(): array
    {
        return $this->config[self::KEY_TABLENAMES];
    }

    public function getTableName(string $name): string
    {
        return $this->getTableNames()[$name] ?? null;
    }

    public function getWorkflowTableName(): string
    {
        return $this->getTableName(KeyConstant::WORKFLOWS_TABLE_NAME_KEY);
    }

    public function getWorkflowStateTableName(): string
    {
        return $this->getTableName(KeyConstant::WORKFLOW_STATES_TABLE_NAME_KEY);
    }

    public function getWorkflowTransitionTableName(): string
    {
        return $this->getTableName(KeyConstant::WORKFLOW_TRANSITIONS_TABLE_NAME_KEY);
    }

    public function getWorkflowStateTransitionTableName(): string
    {
        return $this->getTableName(KeyConstant::WORKFLOW_STATE_TRANSITIONS_TABLE_NAME_KEY);
    }

    public function load(string $workflowName): array
    {
        $workflow = Workflow::with(['states', 'transitions'])->where('name', $workflowName)->first();
        $config[$workflow->name] = [];
    }
}
