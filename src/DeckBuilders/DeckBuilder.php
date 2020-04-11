<?php

namespace Shomisha\Cards\DeckBuilders;

use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Contracts\DeckBuilder as BuilderContract;
use Shomisha\Cards\Contracts\Deck as DeckContract;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Suites\Suite;

class DeckBuilder implements BuilderContract
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