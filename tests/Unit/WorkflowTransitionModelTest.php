<?php

use Soap\WorkflowStorage\Models\Workflow;
use Soap\WorkflowStorage\Models\WorkflowState;
use Soap\WorkflowStorage\Models\WorkflowTransition;

test('workflow state can be stored in database', function () {
    $workflow = Workflow::factory()->create();
    $initialState = WorkflowState::factory()->create([
        'workflow_id' => $workflow->id,
        'name' => 'draft',
    ]);
    $targetState = WorkflowState::factory()->create([
        'workflow_id' => $workflow->id,
        'name' => 'on review',
    ]);
    $transition = WorkflowTransition::factory()->create([
        'workflow_id' => $workflow->id,
        'to_state_id' => $targetState->id,
        'name' => 'submit',
    ]);

    expect($initialState->name)->toBe('draft');
    expect($initialState->workflow->id)->toBe($workflow->id);
    expect($workflow->states->count())->toBe(2);
    expect($workflow->transitions->count())->toBe(1);
    expect($transition->name)->toBe('submit');
    expect($transition->to_state_id)->toBe($targetState->id);
});
