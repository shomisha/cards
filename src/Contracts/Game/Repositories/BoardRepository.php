<?php

namespace Shomisha\Cards\Contracts\Game\Repositories;

use Shomisha\Cards\Contracts\Game\Board;

interface BoardRepository
{
    /**
     * Persist the given instance of Board and return its id.
     * This method should perform an upsert operation.
     *
     * @param \Shomisha\Cards\Contracts\Game\Board $board
     * @return string
     */
    public function save(Board $board): string;

    /**
     * Load an instance of Board based on its id.
     *
     * @param string $id
     * @return \Shomisha\Cards\Contracts\Game\Board|null
     */
    public function load(string $id): ?Board;
}