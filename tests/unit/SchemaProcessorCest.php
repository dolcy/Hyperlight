<?php

declare(strict_types=1);

use Hyperlight\Config\DataConnector;
use Hyperlight\Domain\SchemaProcessor;

class SchemaProcessorCest
{
    public function _before(UnitTester $I): void
    {
        $db = new DataConnector();
        $this->pipeline = new SchemaProcessor($db);
    }

    // tests
    public function testSchemaProcessor(UnitTester $I): void
    {
        $processor = $this->pipeline->compile();
    }
}
