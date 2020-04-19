<?php

namespace Shomisha\Cards\Contracts\Game;

interface Effect
{
    public function apply(Game $game);
}