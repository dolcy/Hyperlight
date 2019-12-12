<?php declare(strict_types=1);

use Hyperlight\Config\Database;

class DataConnectorCest
{
    public function _before(UnitTester $I)
    {
        $database = new Database();

        return $database->dataConnector();
    }

    // tests
    public function testForDataConnection(UnitTester $I): void
    {
        $I->wantTo('test database host connection');
        $I->expect('to get connection');
    }
}
