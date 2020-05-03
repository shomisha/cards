<?php

namespace Shomisha\Cards\Serializers\BoardPosition;

use Shomisha\Cards\Contracts\Game\BoardPosition;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedBoardPosition;

class JsonBoardPositionSerializer extends ArrayBoardPositionSerializer
{
    public function serialize(BoardPosition $position)
    {
        $array = parent::serialize($position);

        return json_encode($array);
    }

    public function unserialize($serialized): BoardPosition
    {
        $array = json_decode($serialized, true);

        if (!is_array($array)) {
            throw InvalidSerializedBoardPosition::invalidJson();
        }

        return parent::unserialize($array);
    }
}