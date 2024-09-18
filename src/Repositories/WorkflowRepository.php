<?php

namespace Soap\WorkflowLoader\Repositories;

use Soap\WorkflowLoader\Models\Workflow;

class WorkflowRepository
{
    protected $model;

    public function __construct(Workflow $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $workflows = $this->model->with(['transitions', 'states'])->get();
        $config = collect([]);
        foreach ($workflows as $workflow) {
            $config = $config->merge($this->makeWorkflowCofig($workflow));
        }

        return $config->toArray();
    }

    public function find($id)
    {
        $workflow = $this->model->with(['transitions', 'states'])->find($id);
        if (! $workflow) {
            return [];
        }

        return $this->makeWorkflowCofig($workflow);
    }

    public function findByName(string $name): array
    {
        $workflowId = $this->model->where('name', $name)->first()->id;
        if (! $workflowId) {
            return [];
        }

        return $this->find($workflowId);
    }

    protected function makeWorkflowCofig($workflow): array
    {
        $places = $workflow->states->map(function ($state) {
            return $state->name;
        })->toArray();

        $transitions = $workflow->transitions->map(function ($transition) {
            return [
                $transition->name => [
                    'from' => $transition->fromStates->map(function ($transitionState) {
                        return $transitionState->fromState->name;
                    })->toArray(),
                    'to' => $transition->toState->name,
                ],
            ];
        })->toArray();

        return [
            $workflow->name => [
                'marking_store' => $workflow->marking_store,
                'type' => $workflow->type ? $workflow->type->value : 'workflow',
                'metadata' => $workflow->metadata,
                'supports' => $workflow->supports,
                'places' => $places,
                'transitions' => $transitions,
            ],
        ];
    }
}
