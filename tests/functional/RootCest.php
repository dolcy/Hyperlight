<?php

declare(strict_types=1);

class RootCest
{
    public function _before(FunctionalTester $I): void
    {
    }

    // tests
    public function checkForRootPage(FunctionalTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Fantastic');
    }
}
