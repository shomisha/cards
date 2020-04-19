<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Card;

interface CardSerializer
{
    public function serialize(Card $card);

    public function unserialize($serialized): Card;
}