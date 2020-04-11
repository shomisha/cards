<?php

namespace Shomisha\Cards\Decks;

use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\Contracts\Deck as DeckContract;

class Deck implements DeckContract
{
    /** @var \Shomisha\Cards\Contracts\Card[] */
    private $cards = [];

    public function __construct(array $cards)
    {
        $this->cards = $cards;
    }

    public function cards(): array
    {
        return $this->cards;
    }

    public function draw(): ?Card
    {
        return array_shift($this->cards);
    }

    public function place(Card $card): DeckContract
    {
        array_unshift($this->cards, $card);

        return $this;
    }

    public function put(Card $card, int $position): DeckContract
    {
        array_splice($this->cards, $position, 0, [$card]);

        return $this;
    }

    public function take(int $position): ?Card
    {
        $card = $this->cards[$position] ?? null;

        array_splice($this->cards, $position, 1);

        return $card;
    }
}