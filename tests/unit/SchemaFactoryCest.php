<?php

declare(strict_types=1);

use Hyperlight\Config\DataConnector;
use Hyperlight\Factory\SchemaFactory;

class SchemaFactoryCest
{
    private $persistence;

    // tests
    public function _before(UnitTester $I): void
    {
        $persistence = new DataConnector();
        $this->schema = new SchemaFactory($persistence);
    }

    // tests
    public function testSchemaFactoryOutput(UnitTester $I, $persistence): void
    {
        $I->wantTo('test the output of the schema factory');
        $schema = $this->schema->generate($persistence);
    }
}
