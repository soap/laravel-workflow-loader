<?php

namespace Soap\WorkflowStorage\Commands;

use Illuminate\Console\Command;

class WorkflowStorageListCommand extends Command
{
    public $signature = 'wf-storage:list-workflows';

    public $description = 'List all workflows';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
