<?php

namespace Soap\WorkflowLoader;

use Soap\WorkflowLoader\Contracts\WorkflowDatabaseLoader;
use Soap\WorkflowLoader\Repositories\WorkflowRepository;

class DatabaseLoader implements WorkflowDatabaseLoader
{
    const KEY_TABLE_NAMES = 'tableNames';

    /**
     * @var array
     */
    protected $config;

    public function __construct(?array $config)
    {
        if (! isset($config[self::KEY_TABLE_NAMES])) {
            throw new \InvalidArgumentException('Table names not found in config');
        }
        $this->config = $config;
    }

    public function getTableNames(): array
    {
        return $this->config[self::KEY_TABLE_NAMES];
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
        $repo = app()->make(WorkflowRepository::class);

        return $repo->findByName($workflowName);
    }

    public function all(): array
    {
        $repo = app()->make(WorkflowRepository::class);

        return $repo->all();
    }
}
