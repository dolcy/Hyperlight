<?php

declare(strict_types=1);

use Hyperlight\Config\DataConnector;
use Hyperlight\Domain\SchemaProcessor;

class SchemaProcessorCest
{
    public function _before(UnitTester $I): void
    {
        $persistence = new DataConnector();
        $this->pipeline = new SchemaProcessor($persistence);
    }

    // tests
    public function testSchemaProcessor(UnitTester $I): void
    {
        $processor = $this->pipeline->compile();
    }
}
