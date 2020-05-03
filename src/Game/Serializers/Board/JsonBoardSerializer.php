<?php

namespace Shomisha\Cards\Game\Serializers\Board;

use Shomisha\Cards\Contracts\Game\Board;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedBoard;

class JsonBoardSerializer extends ArrayBoardSerializer
{
    public function serialize(Board $board)
    {
        $array = parent::serialize($board);

        return json_encode($array);
    }

    public function unserialize($serialized): Board
    {
        $array = json_decode($serialized, true);

        if (!is_array($array)) {
            throw InvalidSerializedBoard::invalidJson();
        }

        return parent::unserialize($array);
    }
}