<?php

return [
    'databaseStorage' => [
        'tableNames' => [
            'workflows' => 'workflows',
            'workflow_states' => 'workflow_states',
            'workflow_transitions' => 'workflow_transitions',
            'workflow_state_transitions' => 'workflow_state_transitions',
        ],
        'loaderClass' => \Soap\WorkflowStorage\DatabaseStorage::class,
    ],
];
