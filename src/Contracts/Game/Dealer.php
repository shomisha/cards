<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Deck;

interface Dealer
{
    public function using(Deck $deck);

    public function dealTo(Player $player);
}