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

    /**
     * Create a deck of multiple decks.
     *
     * @param int $
     * @return \Shomisha\Cards\Contracts\Deck
     */
    public function buildMultiple(int $count): Deck;
}