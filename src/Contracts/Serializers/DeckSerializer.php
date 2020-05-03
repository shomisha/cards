<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Deck;

interface DeckSerializer
{
    /**
     * Serializes a Deck instance.
     *
     * @param \Shomisha\Cards\Contracts\Deck $deck
     * @return mixed
     */
    public function serialize(Deck $deck);

    /**
     * Unserializes a preivously serialized Deck instance.
     *
     * @param $serialized
     * @return \Shomisha\Cards\Contracts\Deck
     */
    public function unserialize($serialized): Deck;
}