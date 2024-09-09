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

    public function load(string $workflowName): array
    {
        return [];
    }
}
