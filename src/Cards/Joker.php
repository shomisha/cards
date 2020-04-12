<?php

namespace Shomisha\Cards\Cards;

use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\Contracts\Suite as SuiteContract;
use Shomisha\Cards\Suites\Suite;

class Joker implements Card
{
    public function rank(): string
    {
        return 'joker';
    }

    public function value(): string
    {
        return 15;
    }

    public function suite(): SuiteContract
    {
        return Suite::JOKER();
    }

    public function identifier(): string
    {
        return 'joker';
    }
}