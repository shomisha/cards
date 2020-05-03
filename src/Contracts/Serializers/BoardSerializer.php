<?php

namespace Shomisha\Cards\Contracts\Serializers;

use Shomisha\Cards\Contracts\Game\Board;

interface BoardSerializer
{
    /**
     * Serialize a Board instance.
     *
     * @param \Shomisha\Cards\Contracts\Game\Board $board
     * @return mixed
     */
    public function serialize(Board $board);

    /**
     * Unserialize a previously serialized Board instance.
     *
     * @param $serialized
     * @return \Shomisha\Cards\Contracts\Game\Board
     */
    public function unserialize($serialized): Board;
}