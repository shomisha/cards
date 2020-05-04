<?php

namespace Shomisha\Cards\Game\BoardPositions;

use Shomisha\Cards\CardGroups\CardStack;
use Shomisha\Cards\Contracts\Game\BoardPosition;
use Shomisha\Cards\Traits\Identifiable;

class StackBoardPosition extends CardStack implements BoardPosition
{
    use Identifiable;
}