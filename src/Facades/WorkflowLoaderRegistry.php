<?php

namespace Soap\WorkflowLoader\Facades;

use Illuminate\Support\Facades\Facade;
use Soap\WorkflowLoader\WorkflowLoader;

/**
 * @see WorkflowLoader
 */
class WorkflowLoaderRegistry extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'workflowLoaderRegistry';
    }
}
