<?php

namespace Soap\WorkflowStorage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Soap\WorkflowStorage\Models\Workflow;
use Soap\WorkflowStorage\Models\WorkflowState;

class WorkflowStateFactory extends Factory
{
    protected $model = WorkflowState::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'initial_state' => 0,
            'final_state' => 0,
            'metadata' => [],
        ];
    }

    public function initialState()
    {
        return $this->state(function (array $attributes) {
            return [
                'initial_state' => 1,
            ];
        });
    }

    public function finalState()
    {
        return $this->state(function (array $attributes) {
            return [
                'final_state' => 1,
            ];
        });
    }

    public function forWorkflow(int|Workflow $workflow)
    {
        $workflowId = is_int($workflow) ? $workflow : $workflow->id;

        return $this->state(function (array $attributes) use ($workflowId) {
            return [
                'workflow_id' => $workflowId,
            ];
        });
    }

    public function withMetadata(array $metadata)
    {
        return $this->state(function (array $attributes) use ($metadata) {
            return [
                'metadata' => $metadata,
            ];
        });
    }
}
