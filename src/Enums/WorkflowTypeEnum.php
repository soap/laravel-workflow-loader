<?php

namespace Soap\WorkflowStorage\Enums;

enum WorkflowTypeEnum: string
{
    case WORKFLOW = 'workflow';
    case STATE_MACHINE = 'state_machine';
}
