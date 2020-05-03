<?php

namespace Shomisha\Cards\Game\Serializers\Hand;

use Shomisha\Cards\Contracts\Game\Hand;
use Shomisha\Cards\Exceptions\InvalidSerializedHand;

class JsonHandSerializer extends ArrayHandSerializer
{
    public function serialize(Hand $hand)
    {
        $array =  parent::serialize($hand);

        return json_encode($array);
    }

    public function unserialize($serialized): Hand
    {
        $array = json_decode($serialized, true);

        if (!is_array($array)) {
            throw InvalidSerializedHand::invalidJson();
        }

        return parent::unserialize($array);
    }
}