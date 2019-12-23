<?php

declare(strict_types=1);

namespace Hyperlight\Bootstrap\Loader;

use Cycle\ORM\Schema;
use Hyperlight\Config\DataConnector;
use Hyperlight\Domain\SchemaProcessor;
use Hyperlight\Factory\SchemaFactory;

class DataLoader
{
    public function load()
    {
        // initiate database connector
        $persistence = new DataConnector();
        $orm = $persistence->connect();
        // generate schema properties
        $schemaFactory = new SchemaFactory($persistence);
        $orm = $schemaFactory->generate($orm);
        // instantiate schema processor
        $schema = new SchemaProcessor($persistence);
        // compile dbal registry options
        $schema = $schema->compile();
        // create new schema with compiled registry
        return $orm->withSchema(new Schema($schema));
    }
}
