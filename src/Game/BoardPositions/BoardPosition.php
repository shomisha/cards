<?php

namespace Shomisha\Cards\Game\BoardPositions;

use Shomisha\Cards\Contracts\Game\BoardPosition as BoardPositionContract;

abstract class BoardPosition implements BoardPositionContract
{
    /** @var \Shomisha\Cards\Contracts\Card[] */
    protected $cards;

    public function getCards(): array
    {
        return $this->cards;
    }

    public function setCards(array $cards): self
    {
        $this->cards = $cards;

        return $this;
    }
}