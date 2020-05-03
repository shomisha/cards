<?php

namespace Shomisha\Cards\Serializers\Player;

use Shomisha\Cards\Contracts\Game\Player;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedPlayer;

class JsonPlayerSerializer extends ArrayPlayerSerializer
{
    public function serialize(Player $player)
    {
        $array = parent::serialize($player);

        return json_encode($array);
    }

    public function unserialize($serialized): Player
    {
        $array = json_decode($serialized, true);

        if (!is_array($array)) {
            throw InvalidSerializedPlayer::invalidJson();
        }

        return parent::unserialize($array);
    }
}