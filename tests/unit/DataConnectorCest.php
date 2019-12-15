<?php

declare(strict_types=1);

use Hyperlight\Config\DataConnector;

class DataConnectorCest
{
    public function _before(UnitTester $I): void
    {
        $this->db = new DataConnector();
    }

    // tests
    public function testForDataConnection(UnitTester $I): void
    {
        $I->wantTo('test database host connection with table');
        $I->lookForwardTo('verifying that a test table was created');
        // new instance of DataConnector
        $connection = $this->db->abstractor();
        // set test database
        $test = $connection->database('default')->table('cycle_test');
        // create test schema
        $schema = $test->getSchema();
        $schema->primary('id');
        $schema->string('status');
        $schema->datetime('created_at');
        $schema->datetime('updated_at');
        $schema->save();
        // insert test data
        $test->insertOne([
            'status'       => 'Connection test is green',
            'created_at' => new DateTimeImmutable(),
            'updated_at' => new DateTimeImmutable(),
        ]);
        $I->expect('to get persistent connection to cycle_test table/record');
        $I->seeInDatabase('cycle_test', ['status' => 'Connection test is green']);
    }

    public function _after(UnitTester $I): void
    {
        $this->db = null;
    }
}
