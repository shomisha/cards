<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Game\Hand;

interface HandSerializer
{
    /**
     * Serialize a Hand instance.
     *
     * @param \Shomisha\Cards\Contracts\Game\Hand $hand
     * @return mixed
     */
    public function serialize(Hand $hand);

    /**
     * Unserialize a previously serialized Hand instance.
     *
     * @param $serialized
     * @return \Shomisha\Cards\Contracts\Game\Hand
     */
    public function unserialize($serialized): Hand;
}