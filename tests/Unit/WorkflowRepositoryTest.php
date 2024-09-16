<?php

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

    $cancelledState = $orderWorkflow->states()->create([
        'name' => 'cancelled',
        'metadata' => [],
    ]);

    $packeddState = $orderWorkflow->states()->create([
        'name' => 'packed',
        'metadata' => [],
    ]);

    $shippedState = $orderWorkflow->states()->create([
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
        'to_state_id' => $cancelledState->id,
        'metadata' => [],
    ]);

});
