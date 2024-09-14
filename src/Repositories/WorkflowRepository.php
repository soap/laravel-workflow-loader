<?php

namespace Soap\WorkflowStorage\Repositories;

use Soap\WorkflowStorage\Models\Workflow;

class WorkflowRepository
{
    protected $model;

    public function __construct(Workflow $model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        $workflow = $this->model->with(['transitions', 'states'])->find($id);
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
                'supports' => $workflow->supports,
                'places' => $places,
                'transitions' => $transitions,
            ],
        ];
    }

    public function findByName(string $name): array
    {
        $workflowId = $this->model->where('name', $name)->first()->id;
        if (! $workflowId) {
            return [];
        }

        return $this->find($workflowId);
    }
}
