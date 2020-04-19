<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Card;

interface BoardPosition
{
    const FACE_UP = 'face-up';
    const FACE_DOWN = 'face-down';

    public function isRevealed(): bool;

    public function reveal(): ?Card;

    public function hide(): void;

    public function putCard(Card $card): self;

    public function takeCard(): ?Card;

    public function peek(): ?Card;
}