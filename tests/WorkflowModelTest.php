<?php

use Soap\WorkflowStorage\Models\Workflow;

test('workflow can store in database', function () {
    $workflow = Workflow::create([
        'name' => 'Example Workflow',
        'type' => 'workflow',
    ]);

    expect($workflow->name)->toBe('Example Workflow');
    expect($workflow->type->value)->toBe('workflow');
});
