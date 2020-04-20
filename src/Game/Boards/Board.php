<?php

namespace Shomisha\Cards\Game\Boards;

use Shomisha\Cards\Contracts\Game\Board as BoardContract;
use Shomisha\Cards\Contracts\Game\BoardPosition;

abstract class Board implements BoardContract
{
    /** @var \Shomisha\Cards\Contracts\Game\BoardPosition[] */
    protected $positions = [];

    public function __construct()
    {
        $this->positions = $this->getPositionsStructure();
    }

    abstract function getPositionsStructure(): array;

    abstract function validatePosition(string $positionName, BoardPosition $position);

    public function getActualPositions(): array
    {
        return $this->positions;
    }

    public function getFreePositions(): array
    {
        return array_filter($this->positions, function ($position) {
            return $position === null;
        });
    }

    public function getPosition(string $position): ?BoardPosition
    {
        // TODO: throw an exception if an invalid position is requested
        return $this->positions[$position];
    }

    public function putOn(string $positionName, BoardPosition $position): BoardContract
    {
        $this->validatePosition($positionName, $position);

        $this->positions[$positionName] = $position;

        return $this;
    }
}