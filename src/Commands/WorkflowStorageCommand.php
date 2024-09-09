<?php

namespace Soap\WorkflowStorage\Commands;

use Illuminate\Console\Command;

class WorkflowStorageCommand extends Command
{
    public $signature = 'laravel-workflow-storage';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
