<?php

use Soap\WorkflowLoader\Models\Workflow;
use Soap\WorkflowLoader\Models\WorkflowState;

test('workflow state can be stored in database', function () {
    $workflow = Workflow::factory()->create();
    $state = WorkflowState::factory()->create([
        'workflow_id' => $workflow->id,
        'name' => 'draft',
    ]);

    expect($state->name)->toBe('draft');
    expect($state->workflow->id)->toBe($workflow->id);
    expect($workflow->states->count())->toBe(1);
});
