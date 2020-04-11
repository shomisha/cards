<?php

namespace Shomisha\Cards\Contracts;

interface DeckBuilder
{
    /**
     * Build a deck.
     *
     * @return \Shomisha\Cards\Contracts\Deck
     */
    public function build(): Deck;
}