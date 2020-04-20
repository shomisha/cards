<?php

namespace Shomisha\Cards\Game\Boards;

use Shomisha\Cards\Contracts\Game\Board as BoardContract;
use Shomisha\Cards\Contracts\Game\BoardPosition as BoardPositionContract;
use Shomisha\Cards\Game\BoardPositions\StackBoardPosition;

class StackBoard implements BoardContract
{
    /** @var \Shomisha\Cards\Game\BoardPositions\StackBoardPosition */
    protected $stack;

    public function __construct()
    {
        $this->stack = new StackBoardPosition();
    }

    public function stack(): StackBoardPosition
    {
        return $this->stack;
    }

    public function getPositionsStructure(): array
    {
        return [
            'stack' => new StackBoardPosition(),
        ];
    }

    public function getActualPositions(): array
    {
        return [
            'stack' => $this->stack,
        ];
    }

    public function getFreePositions(): array
    {
        return [
            'stack' => $this->stack,
        ];
    }

    public function getPosition(string $position): ?BoardPositionContract
    {
        return $this->stack;
    }

    public function putOn(string $positionName, BoardPositionContract $position): BoardContract
    {
        return $this;
    }
}