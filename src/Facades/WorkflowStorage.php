<?php

namespace Soap\WorkflowStorage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Soap\WorkflowStorage\WorkflowStorage
 */
class WorkflowStorage extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'workflow-storage';
    }
}
