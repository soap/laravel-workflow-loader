<?php

namespace Soap\WorkflowStorage\Repositories;

use Soap\WorkflowStorage\Models\Workflow;

class WorkflowRepository
{
    public function all()
    {
        return [];
    }

    public function find($id)
    {
        //$workflow = Workflow::with(['transitions.stateTransitions', 'states'])->find($id);
    }
}
