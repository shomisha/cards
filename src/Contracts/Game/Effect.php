<?php

namespace Shomisha\Cards\Contracts\Game;

interface Effect
{
    /**
     * The effect the move belongs to.
     *
     * @return \Shomisha\Cards\Contracts\Game\Move
     */
    public function move(): Move;

    /**
     * Apply the effect using the specified Game instance.
     *
     * @param \Shomisha\Cards\Contracts\Game\Game $game
     * @return mixed
     */
    public function apply(Game $game);
}