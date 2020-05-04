<?php

namespace Shomisha\Cards\Game;

use Shomisha\Cards\CardGroups\CardStack;
use Shomisha\Cards\Contracts\Game\Hand as HandContract;
use Shomisha\Cards\Traits\Identifiable;

class Hand extends CardStack implements HandContract
{
    use Identifiable;
}