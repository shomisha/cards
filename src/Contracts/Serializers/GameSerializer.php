<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Game\Game;

interface GameSerializer
{
    /**
     * Serializes a Game instance.
     *
     * @param \Shomisha\Cards\Contracts\Game\Game $game
     * @return mixed
     */
    public function serialize(Game $game);

    /**
     * Unserializes a game instance.
     *
     * @param $serialized
     * @return \Shomisha\Cards\Contracts\Game\Game
     */
    public function unserialize($serialized): Game;
}