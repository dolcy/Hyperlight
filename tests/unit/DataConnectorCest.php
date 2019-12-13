<?php declare(strict_types=1);

use Hyperlight\Config\DataConnector;

class DataConnectorCest
{
    public function _before(UnitTester $I): void
    {
        //
    }

    // tests
    public function testForDataConnection(UnitTester $I): void
    {
        $I->wantTo('test database host connection');
        $I->expect('to get persistent connection');
        $db = new DataConnector();
        $connection = $db->connect();
        $dbal = $db->abstractor();
    }
}
