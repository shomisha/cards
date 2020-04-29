<?php

namespace Shomisha\Cards\Game\Boards;

use Shomisha\Cards\Contracts\Game\Board as BoardContract;
use Shomisha\Cards\Game\BoardPositions\StackBoardPosition;

class StackBoard extends Board
{
    public function initializePositions(): BoardContract
    {
        $this->positions['stack'] = new StackBoardPosition();

        return $this;
    }

    public function getStack(): StackBoardPosition
    {
        return $this->positions['stack'];
    }
}