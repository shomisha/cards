<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Deck;

interface Game
{
    public function begin(): self;

    public function advance(Move $move): self;

    /** @return \Shomisha\Cards\Contracts\Game\Player[] */
    public function players(): array;

    public function currentPlayer(): ?Player;

    public function nextPlayer(): Player;

    public function board(): Board;

    public function deck(): Deck;
}