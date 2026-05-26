<?php

use Soap\WorkflowLoader\Models\Workflow;
use Soap\WorkflowLoader\Repositories\WorkflowRepository;

beforeEach(function () {
    $workflow = Workflow::create([
        'name' => 'test_workflow',
        'type' => 'workflow',
        'description' => 'Test Workflow Description',
        'supports' => ['App\Models\Article'],
        'metadata' => [],
    ]);

    $draftState = $workflow->states()->create([
        'name' => 'draft',
        'metadata' => [],
    ]);

    $onReviewState = $workflow->states()->create([
        'name' => 'on review',
        'metadata' => [],
    ]);

    $workflow->states()->create([
        'name' => 'approved',
        'metadata' => [],
    ]);

    $workflow->states()->create([
        'name' => 'rejected',
        'metadata' => [],
    ]);

    $onReviewTransition = $workflow->transitions()->create([
        'name' => 'submit',
        'to_state_id' => $onReviewState->id,
        'metadata' => [],
    ]);

    $onReviewTransition->fromStates()->create([
        'from_state_id' => $draftState->id,
    ]);

    $orderWorkflow = Workflow::create([
        'name' => 'order_process',
        'type' => 'workflow',
        'description' => 'Test Workflow Description',
        'supports' => ['App\Models\Order'],
        'metadata' => [],
    ]);

    $pendingState = $orderWorkflow->states()->create([
        'name' => 'pending',
        'metadata' => [],
    ]);

    $approvedState = $orderWorkflow->states()->create([
        'name' => 'approved',
        'metadata' => [],
    ]);

    $orderWorkflow->states()->create([
        'name' => 'cancelled',
        'metadata' => [],
    ]);

    $orderWorkflow->states()->create([
        'name' => 'packed',
        'metadata' => [],
    ]);

    $orderWorkflow->states()->create([
        'name' => 'shipped',
        'metadata' => [],
    ]);

    $orderWorkflow->transitions()->create([
        'name' => 'approve',
        'to_state_id' => $approvedState->id,
        'metadata' => [],
    ]);

    $orderWorkflow->transitions()->create([
        'name' => 'cancel',
        'to_state_id' => $approvedState->id,
        'metadata' => [],
    ]);
});

it('returns all workflows as a keyed config array', function () {
    $repo = app(WorkflowRepository::class);
    $all = $repo->all();

    expect($all)->toHaveKey('test_workflow');
    expect($all)->toHaveKey('order_process');
});

it('all() returns correct places count for each workflow', function () {
    $repo = app(WorkflowRepository::class);
    $all = $repo->all();

    expect($all['test_workflow']['places'])->toHaveCount(4);
    expect($all['order_process']['places'])->toHaveCount(5);
});

it('all() returns correct transitions count for each workflow', function () {
    $repo = app(WorkflowRepository::class);
    $all = $repo->all();

    expect($all['test_workflow']['transitions'])->toHaveCount(1);
    expect($all['order_process']['transitions'])->toHaveCount(2);
});

it('find() returns correct workflow config by id', function () {
    $repo = app(WorkflowRepository::class);
    $workflow = Workflow::where('name', 'test_workflow')->first();
    $config = $repo->find($workflow->id);

    expect($config)->toHaveKey('test_workflow');
    expect($config['test_workflow']['places'])->toHaveCount(4);
    expect($config['test_workflow']['transitions'])->toHaveCount(1);
});

it('find() returns empty array for non-existent id', function () {
    $repo = app(WorkflowRepository::class);
    $config = $repo->find(9999);

    expect($config)->toBe([]);
});

it('findByName() returns correct workflow config', function () {
    $repo = app(WorkflowRepository::class);
    $config = $repo->findByName('test_workflow');

    expect($config)->toHaveKey('test_workflow');
    expect($config['test_workflow']['transitions']['submit']['from'])->toBe(['draft']);
    expect($config['test_workflow']['transitions']['submit']['to'])->toBe('on review');
});

it('findByName() returns empty array for non-existent workflow name', function () {
    $repo = app(WorkflowRepository::class);
    $config = $repo->findByName('non_existent_workflow');

    expect($config)->toBe([]);
});

it('findByName() includes correct workflow metadata', function () {
    $repo = app(WorkflowRepository::class);
    $config = $repo->findByName('test_workflow');

    expect($config['test_workflow']['type'])->toBe('workflow');
    expect($config['test_workflow']['supports'])->toBe(['App\Models\Article']);
});
