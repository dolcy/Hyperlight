<?php

declare(strict_types=1);

class RootCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function checkForRootPage(FunctionalTester $I) : FuntionalTeser
    {
        $I->amOnPage('/');
        $I->see('Fantastic');
    }
}