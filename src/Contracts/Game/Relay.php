<?php

namespace Shomisha\Cards\Contracts\Game;

interface Relay
{
    public function notify(Player $player, Message $message);
}