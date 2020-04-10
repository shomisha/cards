<?php

namespace Shomisha\Cards\Builders;

use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Contracts\Builder as BuilderContract;
use Shomisha\Cards\Contracts\Deck as DeckContract;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Suites\Suite;

class Builder implements BuilderContract
{
    public function build(): DeckContract
    {
        $cards = [];

        foreach (Suite::all() as $suite) {
            foreach (Card::RANKS as $value => $rank) {
                $cards[] = new Card($suite, $value);
            }
        }

        return new Deck($cards);
    }
}