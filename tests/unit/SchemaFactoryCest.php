<?php

declare(strict_types=1);

use Hyperlight\Factory\SchemaFactory;

class SchemaFactoryCest
{
    public function _before(UnitTester $I): void
    {
        $this->schema = new SchemaFactory();
    }

    // tests
    public function testSchemaFactoryOutput(UnitTester $I): void
    {
        $I->wantTo('test the output of the schema factory');
        $schema = $this->schema->generate();
    }
}
