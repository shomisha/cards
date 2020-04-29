<?php

namespace Shomisha\Cards\Contracts;

use Shomisha\Cards\Contracts\Card;

interface CardGroup
{
    /** @return \Shomisha\Cards\Contracts\Card[] */
    public function getCards(): array;

    /** @param \Shomisha\Cards\Contracts\Card[] $cards */
    public function setCards(array $cards);
}