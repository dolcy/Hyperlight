<?php

declare(strict_types=1);

use Hyperlight\Domain\SchemaPipeline;

class SchemaPipelineCest
{
    public function _before(UnitTester $I): void
    {
        $this->pipeline = new SchemaPipeline();
    }

    // tests
    public function testSchemaPipeline(UnitTester $I): void
    {
        $anno = $this->pipeline->build();
    }
}
