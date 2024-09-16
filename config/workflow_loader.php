<?php

return [
    'databaseLoader' => [
        'tableNames' => [
            'workflows' => 'workflows',
            'workflow_states' => 'workflow_states',
            'workflow_transitions' => 'workflow_transitions',
            'workflow_state_transitions' => 'workflow_state_transitions',
        ],
        'loaderClass' => \Soap\WorkflowLoader\DatabaseLoader::class,
    ],
];
