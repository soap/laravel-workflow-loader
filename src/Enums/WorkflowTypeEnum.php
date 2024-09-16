<?php

namespace Soap\WorkflowLoader\Enums;

enum WorkflowTypeEnum: string
{
    case WORKFLOW = 'workflow';
    case STATE_MACHINE = 'state_machine';
}
