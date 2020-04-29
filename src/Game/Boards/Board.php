<?php

namespace Shomisha\Cards\Game\Boards;

use Shomisha\Cards\Contracts\Game\Board as BoardContract;
use Shomisha\Cards\Contracts\Game\BoardPosition;

abstract class Board implements BoardContract
{
    /** @var BoardPosition[] */
    protected $positions = [];

    public function __construct()
    {
        $this->initializePositions();
    }

    public function getPositions(): array
    {
        return $this->positions;
    }

    public function getPosition(string $position): ?BoardPosition
    {
        return $this->positions[$position] ?? null;
    }

    public function putOn(string $positionName, BoardPosition $position): BoardContract
    {
        $this->positions[$positionName] = $position;

        return $this;
    }
}