<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Game\BoardPosition;

interface BoardPositionSerializer
{
    /**
     * Serialize a BoardPosition instance.
     *
     * @param \Shomisha\Cards\Contracts\Game\BoardPosition $position
     * @return mixed
     */
    public function serialize(BoardPosition $position);

    /**
     * Unserialize a previously serialized BoardPosition instance.
     *
     * @param $serialized
     * @return \Shomisha\Cards\Contracts\Game\BoardPosition
     */
    public function unserialize($serialized): BoardPosition;
}