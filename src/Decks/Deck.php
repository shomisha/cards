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

    public function peek(int $position = 0): ?Card
    {
        return (clone $this->cards[$position]) ?? null;
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

    public function split(int $position = -1): array
    {
        if ($position == -1) {
            $position = random_int(1, count($this->cards())) - 1;
        }

        $split = array_slice($this->cards, 0, $position);
        $this->cards = array_slice($this->cards, $position);

        return [
            new Deck($split),
            $this
        ];
    }

    public function join(DeckContract $otherDeck): DeckContract
    {
        while ($card = $otherDeck->draw()) {
            $this->place($card);
        }

        return $this;
    }
}