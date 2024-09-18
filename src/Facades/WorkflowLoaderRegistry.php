<?php

namespace Soap\WorkflowLoader\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Soap\WorkflowLoader\WorkflowLoader
 */
class WorkflowLoader extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Soap\WorkflowLoader\WorkflowLoaderRegistry::class;
    }
}
