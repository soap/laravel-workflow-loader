<?php

use Soap\WorkflowStorage\Models\Workflow;

beforeEach(function () {

    $workflow = Workflow::create([
        'name' => 'Test Workflow',
        'type' => 'workflow',
        'description' => 'Test Workflow Description',
        'supports' => [],
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

test('data can be retrieved from the database', function () {
    $workflow = Workflow::first();
    $states = $workflow->states;
    $transitions = $workflow->transitions;

    expect($workflow->name)->toBe('Test Workflow');
    expect($workflow->type->value)->toBe('workflow');
    expect($workflow->description)->toBe('Test Workflow Description');
    expect($workflow->supports)->toBe([]);
    expect($workflow->metadata)->toBe([]);

    expect($states->count())->toBe(4);
    expect($transitions->count())->toBe(1);
});
