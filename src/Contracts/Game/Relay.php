<?php

namespace Shomisha\Cards\Contracts\Game;

interface Relay
{
    /**
     * Conveys a signal from the backend to the frontend.
     *
     * @param \Shomisha\Cards\Contracts\Game\Player $player
     * @param \Shomisha\Cards\Contracts\Game\Message $message
     * @return mixed
     */
    public function notify(Player $player, Message $message);
}