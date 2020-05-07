<?php

namespace Shomisha\Cards\Contracts\Game\Repositories;

use Shomisha\Cards\Contracts\Game\BoardPosition;

interface BoardPositionRepository
{
    /**
     * Persist the given instance of BoardPosition and return its id.
     * This method should perform an upsert operation.
     *
     * @param \Shomisha\Cards\Contracts\Game\BoardPosition $position
     * @return string
     */
    public function save(BoardPosition $position): string;

    /**
     * Load an instance of BoardPosition based on its identifier.
     *
     * @param string $id
     * @return \Shomisha\Cards\Contracts\Game\BoardPosition|null
     */
    public function load(string $id): ?BoardPosition;
}