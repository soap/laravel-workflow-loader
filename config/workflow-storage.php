<?php

// config for Soap/WorkflowStorage
return [
    'database' => [
        'connection' => 'mysql',
        'table_names' => [
            'workflows' => 'workflows',
            'workflow_transitions' => 'workflow_transitions',
            'workflow_transition_log' => 'workflow_transition_log',
            'workflow_transition_log_data' => 'workflow_transition_log_data',
            'workflow_places' => 'workflow_places',
            'workflow_arcs' => 'workflow_arcs',
        ],
        'loader_class' => \Soap\WorkflowStorage\DatabaseLoader::class,
    ],
];
