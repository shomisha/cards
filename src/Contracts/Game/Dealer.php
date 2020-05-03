<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Deck;

interface Dealer
{
    /**
     * Set the deck used for dealing.
     *
     * @param \Shomisha\Cards\Contracts\Deck $deck
     * @return mixed
     */
    public function using(Deck $deck);

    /**
     * Deal to the specified player.
     *
     * @param \Shomisha\Cards\Contracts\Game\Player $player
     * @return mixed
     */
    public function dealTo(Player $player);
}