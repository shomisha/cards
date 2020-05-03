<?php

namespace Shomisha\Cards\Contracts\Game;

interface Player
{
    /**
     * Returns the name of the player.
     *
     * @return string
     */
    public function name(): string;

    /**
     * Returns the Hand instance the player currently holds.
     *
     * @return \Shomisha\Cards\Contracts\Game\Hand|null
     */
    public function getHand(): ?Hand;

    /**
     * Sets the Hand instance on the player.
     *
     * @param \Shomisha\Cards\Contracts\Game\Hand $hand
     */
    public function setHand(Hand $hand);
}