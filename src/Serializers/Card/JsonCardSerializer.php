<?php

namespace Shomisha\Cards\Serializers\Card;

use Shomisha\Cards\Contracts\Card as CardContract;
use Shomisha\Cards\Exceptions\InvalidSerializedCard;

class JsonCardSerializer extends ArrayCardSerializer
{
    /** @return string */
    public function serialize(CardContract $card)
    {
        $array = parent::serialize($card);

        return json_encode($array);
    }

    /** @param string $serialized */
    public function unserialize($serialized): CardContract
    {
        $array = json_decode($serialized, true);

        if ($array === null) {
            throw InvalidSerializedCard::invalidJson();
        }

        return parent::unserialize($array);
    }
}