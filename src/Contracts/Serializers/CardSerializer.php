<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Card;

interface CardSerializer
{
    /**
     * Serializes a Card instance.
     *
     * @param \Shomisha\Cards\Contracts\Card $card
     * @return mixed
     */
    public function serialize(Card $card);

    /**
     * Unserializes a previously serialized Card instance.
     *
     * @param $serialized
     * @return \Shomisha\Cards\Contracts\Card
     */
    public function unserialize($serialized): Card;
}