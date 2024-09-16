<?php

use Soap\WorkflowLoader\WorkflowData;

it('can create a workflow data', function () {
    $wfData = new WorkflowData(name: 'article', supports: ["App\Models\Article"]);
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
