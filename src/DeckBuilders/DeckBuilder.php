<?php

namespace Shomisha\Cards\DeckBuilders;

use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Contracts\DeckBuilder as BuilderContract;
use Shomisha\Cards\Contracts\Deck as DeckContract;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Suites\Suite;

class DeckBuilder implements BuilderContract
{
    /** @var bool  */
    private $withJokers = true;

    public function withJokers(bool $withJokers = true): DeckBuilder
    {
        $builder = clone $this;

        $builder->withJokers = $withJokers;

        return $builder;
    }

    public function build(): DeckContract
    {
        return new Deck($this->getCards());
    }

    public function buildMultiple(int $count): DeckContract
    {
        return new Deck(array_merge(...array_fill(0, $count, $this->getCards())));
    }

    protected function getCards()
    {
        $cards = [];

        foreach (Suite::all() as $suite) {
            foreach (Card::RANKS as $value => $rank) {
                $cards[] = new Card($suite, $value);
            }
        }

        if ($this->withJokers) {
            $cards = array_merge($cards, [
                new Joker(),
                new Joker(),
            ]);
        }

        return $cards;
    }
}