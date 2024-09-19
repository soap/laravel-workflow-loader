<?php

namespace Soap\WorkflowLoader\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Soap\WorkflowLoader\WorkflowLoader
 */
class WorkflowLoaderRegistry extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'workflowLoaderRegistry';
    }
}
