<?php

namespace Shomisha\Cards\Game\BoardPositions;

use Shomisha\Cards\Contracts\Game\BoardPosition;
use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\Traits\Identifiable;

class CardBoardPosition implements BoardPosition
{
    use Identifiable;

    /** @var Card */
    protected $card;

    public function __construct(Card $card = null)
    {
        $this->card = $card;
    }

    public function getCards(): array
    {
        return [$this->card];
    }

    public function setCards(array $cards): self
    {
        if (count($cards) > 1) {
            throw new \InvalidArgumentException("Card position cannot contain more than a single card.");
        }

        $this->card = $cards[0];

        return $this;
    }

    public function put(Card $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function peek(): ?Card
    {
        if ($this->card) {
            return clone $this->card;
        }

        return null;
    }

    public function take(): ?Card
    {
        $card = $this->card;

        $this->card = null;

        return $card;
    }
}