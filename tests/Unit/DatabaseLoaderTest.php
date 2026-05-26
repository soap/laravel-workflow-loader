<?php

use Soap\WorkflowLoader\DatabaseLoader;
use Soap\WorkflowLoader\Repositories\WorkflowRepository;

it('throws InvalidArgumentException when tableNames config key is missing', function () {
    $repo = app(WorkflowRepository::class);
    new DatabaseLoader([], $repo);
})->throws(InvalidArgumentException::class, 'Table names not found in config');

it('throws InvalidArgumentException when config is null', function () {
    $repo = app(WorkflowRepository::class);
    new DatabaseLoader(null, $repo);
})->throws(InvalidArgumentException::class, 'Table names not found in config');

it('returns correct workflow table name', function () {
    $loader = app(DatabaseLoader::class);
    expect($loader->getWorkflowTableName())->toBe('workflows');
});

it('returns correct workflow states table name', function () {
    $loader = app(DatabaseLoader::class);
    expect($loader->getWorkflowStateTableName())->toBe('workflow_states');
});

it('returns correct workflow transitions table name', function () {
    $loader = app(DatabaseLoader::class);
    expect($loader->getWorkflowTransitionTableName())->toBe('workflow_transitions');
});

it('returns correct workflow state transitions table name', function () {
    $loader = app(DatabaseLoader::class);
    expect($loader->getWorkflowStateTransitionTableName())->toBe('workflow_state_transitions');
});

it('getTableName() returns null for unknown table key', function () {
    $loader = app(DatabaseLoader::class);
    expect($loader->getTableName('unknown_table'))->toBeNull();
});

it('getTableNames() returns all four table names', function () {
    $loader = app(DatabaseLoader::class);
    $tableNames = $loader->getTableNames();

    expect($tableNames)->toHaveKeys([
        'workflows',
        'workflow_states',
        'workflow_transitions',
        'workflow_state_transitions',
    ]);
});
