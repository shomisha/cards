<?php

namespace Shomisha\Cards\Contracts\Game;

interface Effect
{
    public function move(): Move;

    public function apply(Game $game);
}