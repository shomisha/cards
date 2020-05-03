<?php

namespace Shomisha\Cards\Contracts;

use Shomisha\Cards\Contracts\Card;

interface CardGroup
{
    /**
     * Returns the cards stored in this group.
     *
     * @return \Shomisha\Cards\Contracts\Card[]
     */
    public function getCards(): array;

    /**
     * Sets the cards to be stored in this group.
     *
     * @param \Shomisha\Cards\Contracts\Card[] $cards
     */
    public function setCards(array $cards);
}