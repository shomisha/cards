<?php

namespace Shomisha\Cards\Contracts;

interface Card
{
    const RANKS = [
        1 => 'Ace',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        12 => 'Jack',
        13 => 'Queen',
        14 => 'King',
    ];

    /**
     * The name of the card.
     *
     * @return string
     */
    public function rank(): string;

    /**
     * The numeric value of the card.
     *
     * @return string
     */
    public function value(): string;

    /**
     * The suite the card belongs to.
     *
     * @return \Shomisha\Cards\Contracts\Suite
     */
    public function suite(): Suite;

    /**
     * Returns a unique identifier for the card object.
     *
     * @return string
     */
    public function identifier(): string;
}