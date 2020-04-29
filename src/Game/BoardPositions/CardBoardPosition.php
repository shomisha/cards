<?php

namespace Shomisha\Cards\Game\BoardPositions;

use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\Contracts\CardGroup;

class CardBoardPosition extends BoardPosition
{
    public function setCards(array $cards): CardGroup
    {
        if (count($cards) > 1) {
            throw new \InvalidArgumentException("Card position cannot contain more than a single card.");
        }

        $this->cards = $cards;
    }

    public function put(Card $card): self
    {
        $this->cards = [$card];

        return $this;
    }

    public function peek(): ?Card
    {
        return $this->cards[0] ?? null;
    }

    public function take(): ?Card
    {
        $card = $this->cards[0] ?? null;

        $this->cards = [];

        return $card;
    }
}