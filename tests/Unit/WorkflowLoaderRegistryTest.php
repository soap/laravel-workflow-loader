<?php

use Soap\WorkflowLoader\Contracts\WorkflowLoader as WorkflowLoaderContract;
use Soap\WorkflowLoader\WorkflowLoaderRegistry;

function makeMockLoader(array $workflows = []): WorkflowLoaderContract
{
    return new class($workflows) implements WorkflowLoaderContract
    {
        public function __construct(private array $workflows) {}

        public function all(): array
        {
            return $this->workflows;
        }

        public function load(string $workflowName): array
        {
            return $this->workflows[$workflowName] ?? [];
        }
    };
}

beforeEach(function () {
    cache()->forget('workflow_loader.registry.all');
});

it('throws InvalidArgumentException when class key is missing in loader config', function () {
    new WorkflowLoaderRegistry(['my_loader' => ['no_class_key' => 'here']]);
})->throws(InvalidArgumentException::class);

it('throws InvalidArgumentException when loader class does not exist', function () {
    new WorkflowLoaderRegistry(['my_loader' => ['class' => 'App\NonExistentLoaderClass']]);
})->throws(InvalidArgumentException::class);

it('returns empty array when no loaders are registered', function () {
    $registry = new WorkflowLoaderRegistry([]);
    expect($registry->all())->toBe([]);
});

it('returns merged workflows from all registered loaders', function () {
    $registry = new WorkflowLoaderRegistry([]);
    $registry->registerLoader('loader_a', makeMockLoader(['workflow_a' => ['type' => 'workflow']]));
    $registry->registerLoader('loader_b', makeMockLoader(['workflow_b' => ['type' => 'state_machine']]));

    $all = $registry->all();

    expect($all)->toHaveKey('workflow_a');
    expect($all)->toHaveKey('workflow_b');
});

it('later loader overwrites earlier loader on duplicate workflow name', function () {
    $registry = new WorkflowLoaderRegistry([]);
    $registry->registerLoader('loader_a', makeMockLoader(['my_wf' => ['type' => 'workflow']]));
    $registry->registerLoader('loader_b', makeMockLoader(['my_wf' => ['type' => 'state_machine']]));

    $all = $registry->all();

    expect($all['my_wf']['type'])->toBe('state_machine');
});

it('getLoader() returns the registered loader by name', function () {
    $registry = new WorkflowLoaderRegistry([]);
    $mock = makeMockLoader();
    $registry->registerLoader('my_loader', $mock);

    expect($registry->getLoader('my_loader'))->toBe($mock);
});

it('getLoader() throws Exception for non-existent loader name', function () {
    $registry = new WorkflowLoaderRegistry([]);
    $registry->getLoader('non_existent');
})->throws(Exception::class);

it('getLoaders() returns all registered loaders', function () {
    $registry = new WorkflowLoaderRegistry([]);
    $registry->registerLoader('loader_a', makeMockLoader());
    $registry->registerLoader('loader_b', makeMockLoader());

    expect($registry->getLoaders())->toHaveCount(2);
    expect($registry->getLoaders())->toHaveKeys(['loader_a', 'loader_b']);
});

it('all() caches results on repeated calls', function () {
    $callCount = 0;

    $loader = new class($callCount) implements WorkflowLoaderContract
    {
        public function __construct(private int &$callCount) {}

        public function all(): array
        {
            $this->callCount++;

            return ['wf' => ['type' => 'workflow']];
        }

        public function load(string $workflowName): array
        {
            return [];
        }
    };

    $registry = new WorkflowLoaderRegistry([]);
    $registry->registerLoader('counting', $loader);

    $registry->all();
    $registry->all();

    expect($callCount)->toBe(1);
});

it('flushCache() clears the cached result', function () {
    $registry = new WorkflowLoaderRegistry([]);
    $registry->registerLoader('mock', makeMockLoader(['wf1' => ['type' => 'workflow']]));

    $registry->all();

    $registry->flushCache();

    expect(cache()->has('workflow_loader.registry.all'))->toBeFalse();
});
