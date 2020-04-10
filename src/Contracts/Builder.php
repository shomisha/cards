<?php

namespace Shomisha\Cards\Contracts;

interface Builder
{
    /**
     * Build a deck.
     *
     * @return \Shomisha\Cards\Contracts\Deck
     */
    public function build(): Deck;
}