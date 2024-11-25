<?php

declare(strict_types=1);

return [
    'default' => 'api',

    'connections' => [
        'api' => [
            'url' => 'http://localhost/v1.47',
            'certificate_path' => '/var/run/docker.sock',
        ],
    ],
];
