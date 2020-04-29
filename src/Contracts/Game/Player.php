<?php

namespace Shomisha\Cards\Contracts\Game;

interface Player
{
    public function name(): string;

    public function getHand(): Hand;

    public function setHand(Hand $hand): self;
}