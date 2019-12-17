<?php

declare(strict_types=1);

namespace Hyperlight\Config;

use Cycle\ORM;
use Cycle\ORM\ORM as Cycle;
use function Siler\Dotenv\env;
use Spiral\Database;
use Spiral\Database\DatabaseManager;

class DataConnector
{
    /**
     * Return dbal manager
     *
     * @return DatabaseManager
     */
    public function abstractor(): DatabaseManager
    {
        // db settings via .env
        $dbHost = env('DB_HOST');
        $dbData = env('DB_DATABASE');
        $dbUser = env('DB_USER');
        $dbPasswd = env('DB_PASSWD');
        $dbPort = env('DB_PORT');

        // dbal connection settings
        return new Database\DatabaseManager(
            new Database\Config\DatabaseConfig([
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
            ])
        );
    }

    /**
     * Returns data manager instance
     *
     * @param $dbal
     * @return Cycle ORM
     */
    public function connect(): Cycle
    {
        $dbal = $this->abstractor();

        // initiate orm factory
        return new Cycle(new ORM\Factory($dbal));
    }
}
