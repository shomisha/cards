<?php

namespace Shomisha\Cards\Game;

use Shomisha\Cards\Contracts\Game\Effect as EffectContract;
use Shomisha\Cards\Contracts\Game\Move;

abstract class Effect implements EffectContract
{
    /** @var \Shomisha\Cards\Contracts\Game\Move */
    private $move;

    public function __construct(Move $move)
    {
        $this->move = $move;
    }

    public function move(): Move
    {
        return $this->move;
    }
}