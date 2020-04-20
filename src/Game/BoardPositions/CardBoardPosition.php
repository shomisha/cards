<?php

namespace Shomisha\Cards\Game\BoardPositions;

use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\Contracts\Game\BoardPosition as BoardPositionContract;

class CardBoardPosition implements BoardPositionContract
{
    /** @var Card */
    protected $card;

    /** @var string */
    protected $side;

    public function __construct(Card $card = null, string $side = null)
    {
        $this->card = $card;
        $this->side = $side ?? BoardPositionContract::FACE_UP;
    }

    public function isRevealed(): bool
    {
        return $this->side === BoardPositionContract::FACE_UP;
    }

    public function reveal(): ?Card
    {
        $this->side = BoardPositionContract::FACE_UP;

        return $this->card;
    }

    public function hide(): void
    {
        $this->side = BoardPositionContract::FACE_DOWN;
    }

    public function putCard(Card $card): BoardPositionContract
    {
        $this->card = $card;
    }

    public function takeCard(): ?Card
    {
        $card = $this->card;

        $this->card = null;

        return $card;
    }

    public function peek(): ?Card
    {
        return $this->card;
    }
}