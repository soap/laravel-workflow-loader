<?php

namespace Soap\WorkflowLoader\Commands;

use Illuminate\Console\Command;

class WorkflowLoaderListCommand extends Command
{
    public $signature = 'wf-Loader:list-workflows';

    public $description = 'List all workflows';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
