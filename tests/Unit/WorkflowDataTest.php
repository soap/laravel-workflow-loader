<?php

use Soap\WorkflowLoader\WorkflowData;

it('can create a workflow data', function () {
    $wfData = new WorkflowData(name: 'article', supports: ['App\\Models\\Article']);
    $wfData->addPlace('draft');
    $wfData->addPlace('on review');
    $wfData->addTransition('submit', 'draft', 'on review');
    $wfData->addTransition('approve', 'on review', 'approved');
    $wfData->addTransition('reject', 'on review', 'rejected');

    $output = $wfData->toArray();

    expect(data_get($output, 'article.transitions.submit.from'))->toBe(['draft']);
    expect(data_get($output, 'article.transitions.submit.to'))->toBe(['on review']);
    expect(data_get($output, 'article.transitions.approve.from'))->toBe(['on review']);
    expect(data_get($output, 'article.transitions.approve.to'))->toBe(['approved']);
    expect(data_get($output, 'article.transitions.reject.from'))->toBe(['on review']);
    expect(data_get($output, 'article.transitions.reject.to'))->toBe(['rejected']);

    expect(count(data_get($output, 'article.places')))->toBe(4);
});

it('does not duplicate places when transition references an already-added place', function () {
    $wfData = new WorkflowData(name: 'test', supports: []);
    $wfData->addPlace('draft');
    $wfData->addPlace('review');
    $wfData->addTransition('submit', 'draft', 'review');

    expect($wfData->getPlaces())->toHaveCount(2);
    expect(array_keys($wfData->getPlaces()))->toBe(['draft', 'review']);
});

it('auto-adds places referenced in transition that were not explicitly added', function () {
    $wfData = new WorkflowData(name: 'test', supports: []);
    $wfData->addTransition('submit', 'draft', 'review');

    expect($wfData->getPlaces())->toHaveKey('draft');
    expect($wfData->getPlaces())->toHaveKey('review');
});

it('accepts array of from-places in addTransition', function () {
    $wfData = new WorkflowData(name: 'test', supports: []);
    $wfData->addPlace('pending');
    $wfData->addPlace('on_hold');
    $wfData->addPlace('approved');
    $wfData->addTransition('approve', ['pending', 'on_hold'], 'approved');

    $output = $wfData->toArray();
    expect(data_get($output, 'test.transitions.approve.from'))->toBe(['pending', 'on_hold']);
});

it('toArray() includes all required workflow keys', function () {
    $wfData = new WorkflowData(name: 'my_wf', type: 'state_machine', supports: ['App\Models\Order']);
    $output = $wfData->toArray();

    expect($output)->toHaveKey('my_wf');
    expect($output['my_wf'])->toHaveKeys([
        'type',
        'supports',
        'marking_store',
        'places',
        'transitions',
        'events_to_dispatch',
    ]);
});

it('uses workflow as default type when not specified', function () {
    $wfData = new WorkflowData(name: 'default_type_wf');
    $output = $wfData->toArray();

    expect($output['default_type_wf']['type'])->toBe('workflow');
});
