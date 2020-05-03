<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Game\Game;

interface Move
{
    /**
     * Return an array of all of the effects
     * that should be applied before the move takes place.
     *
     * @return \Shomisha\Cards\Contracts\Game\Effect[]
     */
    public function getPreApplicationEffects(): array;

    /**
     * Check if the move has any pre-application effects defined.
     *
     * @return bool
     */
    public function hasPreApplicationEffects(): bool;

    /**
     * Return an array of all of the effects
     * that should be applied after the move takes place.
     *
     * @return \Shomisha\Cards\Contracts\Game\Effect[]
     */
    public function getPostApplicationEffects(): array;

    /**
     * Check if the move has any post-application effects defined.
     *
     * @return bool
     */
    public function hasPostApplicationEffects(): bool;

    /**
     * Apply the move to the specified Game instance.
     *
     * @param \Shomisha\Cards\Contracts\Game\Game $game
     */
    public function apply(Game $game): void;
}