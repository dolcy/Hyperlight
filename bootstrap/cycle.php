<?php

declare(strict_types=1);

use Cycle\ORM\Schema;
use Hyperlight\Config\DataConnector;
use Hyperlight\Domain\SchemaProcessor;
use Hyperlight\Factory\SchemaFactory;

// iniitate database connector
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
$orm = $orm->withSchema(new Schema($schema));
