<?php

namespace Shomisha\Cards\CardGroups;

use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\Contracts\CardGroup;

abstract class CardStack implements CardGroup
{
    /** @var \Shomisha\Cards\Contracts\Card[] */
    protected $cards = [];

    public function __construct(array $cards = [])
    {
        $this->validateCards($cards);

        $this->cards = $cards;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function setCards(array $cards): self
    {
        $this->validateCards($cards);

        $this->cards = $cards;

        return $this;
    }

    public function draw(): ?Card
    {
        return array_shift($this->cards);
    }

    public function take(int $position): ?Card
    {
        $card = $this->cards[$position] ?? null;

        array_splice($this->cards, $position, 1);

        return $card;
    }

    public function peek(int $position = 0): ?Card
    {
        return (clone $this->cards[$position]) ?? null;
    }

    public function place(Card $card): self
    {
        array_unshift($this->cards, $card);

        return $this;
    }

    public function put(Card $card, int $position): self
    {
        array_splice($this->cards, $position, 0, [$card]);

        return $this;
    }

    protected function validateCards(array $cards)
    {
        foreach ($cards as $card) {
            if (!$card instanceof Card) {
                throw new \InvalidArgumentException("Not all elements implement the Card interface.");
            }
        }
    }
}