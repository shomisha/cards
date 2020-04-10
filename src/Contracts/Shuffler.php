<?php

namespace Shomisha\Cards\Contracts;

interface Shuffler
{
    /**
     * Shuffles the specified deck.
     *
     * @param \Shomisha\Cards\Contracts\Deck $deck
     * @param int $rounds
     * @return \Shomisha\Cards\Contracts\Deck
     */
    public function shuffle(Deck $deck, int $rounds = 1): Deck;
}