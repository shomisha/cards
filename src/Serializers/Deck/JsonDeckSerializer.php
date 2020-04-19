<?php

namespace Shomisha\Cards\Serializers\Deck;

use Shomisha\Cards\Contracts\Deck as DeckContract;
use Shomisha\Cards\Exceptions\InvalidSerializedDeck;

class JsonDeckSerializer extends ArrayDeckSerializer
{
    /** @return string */
    public function serialize(DeckContract $deck)
    {
        $array = parent::serialize($deck);

        return json_encode($array);
    }

    /** @param string $serialized */
    public function unserialize($serialized): DeckContract
    {
        $array = json_decode($serialized, true);

        if ($array === null) {
            throw InvalidSerializedDeck::invalidJson();
        }

        return parent::unserialize($array);
    }
}