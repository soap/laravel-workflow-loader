<?php

use Illuminate\Support\Arr;
use Soap\WorkflowStorage\Models\Workflow;
use Soap\WorkflowStorage\Repositories\WorkflowRepository;

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

    $approvedState = $workflow->states()->create([
        'name' => 'approved',
        'metadata' => [],
    ]);

    $rejectedState = $workflow->states()->create([
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
});

test('workflow data can be retrieved via models from the database', function () {
    $workflow = Workflow::first();
    $states = $workflow->states;
    $transitions = $workflow->transitions;

    expect($workflow->name)->toBe('test_workflow');
    expect($workflow->type->value)->toBe('workflow');
    expect($workflow->description)->toBe('Test Workflow Description');
    expect($workflow->supports)->toBe(['App\Models\Article']);
    expect($workflow->metadata)->toBe([]);

    expect($states->count())->toBe(4);
    expect($transitions->count())->toBe(1);
});

test('workflow configuration can be retrievd via the repository', function () {
    $repo = app()->make(WorkflowRepository::class);
    $config = $repo->find(1);
    ray($config);
    expect(count($config))->toBe(1);
    expect(count(Arr::get($config, 'test_workflow.places')))->toBe(4);
    expect(count(Arr::get($config, 'test_workflow.transitions')))->toBe(1);
});
