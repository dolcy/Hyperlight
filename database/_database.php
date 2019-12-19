<?php

declare(strict_types=1);

use function Siler\Dotenv\env;
use Spiral\Database;

// db settings via .env
$dbHost = env('DB_HOST');
$dbData = env('DB_DATABASE');
$dbUser = env('DB_USER');
$dbPasswd = env('DB_PASSWD');
$dbPort = env('DB_PORT');

return [
    'default' => 'default',
    'databases' => [
        'default' => ['connection' => 'mysql']
    ],
    'connections' => [
        'mysql' => [
            'driver' => Database\Driver\MySQL\MySQLDriver::class,
            'connection' => "mysql:host=${dbHost};dbname=${dbData};port=${dbPort}",
            'username' => $dbUser,
            'password' => $dbPasswd,
        ],
        'sqlite' => [
            'driver' => Database\Driver\SQLite\SQLiteDriver::class,
            'connection' => 'sqlite:database.db',
            'username' => '',
            'password' => '',
        ]
    ]
];
