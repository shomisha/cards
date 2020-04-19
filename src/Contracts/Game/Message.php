<?php

namespace Shomisha\Cards\Contracts\Game;

interface Message
{
    public function forRelay(Relay $relay): Message;
}