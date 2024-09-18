<?php

return [
    'loaders' => [
        'database' => [
            'tableNames' => [
                'workflows' => 'workflows',
                'workflow_states' => 'workflow_states',
                'workflow_transitions' => 'workflow_transitions',
                'workflow_state_transitions' => 'workflow_state_transitions',
            ],
            'class' => \Soap\WorkflowLoader\DatabaseLoader::class,
        ]
    ],
];