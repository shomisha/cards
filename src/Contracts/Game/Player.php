<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Identifiable;

interface Player extends Identifiable
{
    /**
     * Set the name of the player instance.
     *
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

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