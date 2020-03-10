<?php
return [
    'sphinx' => [
        'driver' => 'mysql',
        'host' => env('SPHINX_HOST', '127.0.0.1'),
        'port' => env('SPHINX_PORT', '9306'),
        'database' => '',
    ], 
];