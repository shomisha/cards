<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Deck;

interface DeckSerializer
{
    public function serialize(Deck $deck);

    public function unserialize($serialized): Deck;
}