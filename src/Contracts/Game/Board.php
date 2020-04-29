<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\CardGroup;

interface Board extends CardGroup
{
    /** @return \Shomisha\Cards\Contracts\Game\BoardPosition[] */
    public function getPositionsStructure(): array;

    /** @return \Shomisha\Cards\Contracts\Game\BoardPosition[] */
    public function getActualPositions(): array;

    /** @return \Shomisha\Cards\Contracts\Game\BoardPosition[] */
    public function getFreePositions(): array;

    public function getPosition(string $position): ?BoardPosition;

    public function putOn(string $positionName, BoardPosition $position): self;
}