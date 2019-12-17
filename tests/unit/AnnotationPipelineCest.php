<?php

declare(strict_types=1);

use Hyperlight\Domain\AnnotationPipeline;

class AnnotationPipelineCest
{
    public function _before(UnitTester $I): void
    {
        $this->pipeline = new AnnotationPipeline();
    }

    // tests
    public function testAnnotationPipeline(UnitTester $I): void
    {
        $anno = $this->pipeline->build();
    }
}
