<?php

namespace Shomisha\Cards\Contracts\Game;

interface Message
{
    /**
     * Return an instance of the message sendable through the specified Relay.
     *
     * @param \Shomisha\Cards\Contracts\Game\Relay $relay
     * @return \Shomisha\Cards\Contracts\Game\Message
     */
    public function forRelay(Relay $relay): Message;
}