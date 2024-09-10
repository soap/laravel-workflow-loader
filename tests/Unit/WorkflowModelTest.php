<?php

use Soap\WorkflowStorage\Models\Workflow;

test('workflow can store in database', function () {
    $workflow = Workflow::factory()->create([
        'name' => 'Example Workflow',
        'type' => 'workflow',
    ]);

    expect($workflow->name)->toBe('Example Workflow');
    expect($workflow->type->value)->toBe('workflow');
});

test('workflow factory is working', function () {
    $workflow = Workflow::factory()->create();

    expect($workflow->name)->not->toBeNull();
    expect($workflow->type->value)->toBe('workflow');
});
