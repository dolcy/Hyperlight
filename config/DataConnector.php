<?php

declare(strict_types=1);

namespace Hyperlight\Config;

use Cycle\ORM;
use Cycle\ORM\ORM as Cycle;
use Spiral\Database;
use Spiral\Database\DatabaseManager;

final class DataConnector
{
    /**
     * Return dbal manager
     *
     * @return DatabaseManager
     */
    public function abstractor(): DatabaseManager
    {
        // get database settings
        $database = require __DIR__ . '/../database/_database.php';

        // dbal connection settings
        return new DatabaseManager(
            new Database\Config\DatabaseConfig($database)
      );
    }

    /**
     * Returns data manager instance
     *
     * @return Cycle ORM
     */
    public function connect(): Cycle
    {
        $dbal = $this->abstractor();

        // initiate orm factory
        return new Cycle(new ORM\Factory($dbal));
    }
}
