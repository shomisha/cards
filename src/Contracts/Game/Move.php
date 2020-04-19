<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Game\Game;

interface Move
{
    /** @return \Shomisha\Cards\Contracts\Game\Effect[] */
    public function getPreApplicationEffects(): array;

    public function hasPreApplicationEffects(): bool;

    /** @return \Shomisha\Cards\Contracts\Game\Effect[] */
    public function getPostApplicationEffects(): array;

    public function hasPostApplicationEffects(): bool;

    public function apply(Game $game): void;
}