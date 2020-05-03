<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Game\Player;

interface PlayerSerializer
{
    /**
     * Serialize a Player instance.
     *
     * @param \Shomisha\Cards\Contracts\Game\Player $player
     * @return mixed
     */
    public function serialize(Player $player);

    /**
     * Unserialize a previously serialized Player instance.
     *
     * @param $serialzied
     * @return \Shomisha\Cards\Contracts\Game\Player
     */
    public function unserialize($serialized): Player;
}