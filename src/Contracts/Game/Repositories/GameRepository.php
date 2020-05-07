<?php

namespace Shomisha\Cards\Contracts\Game\Repositories;

use Shomisha\Cards\Contracts\Game\Game;

interface GameRepository
{
    /**
     * Persist the instance of game and return its id.
     * This method should perform an upsert operation.
     *
     * @param \Shomisha\Cards\Contracts\Game\Game $game
     * @return string
     */
    public function save(Game $game): string;

    /**
     * Load the game from persistent storage based on its id.
     *
     * @param string $id
     * @return \Shomisha\Cards\Contracts\Game\Game|null
     */
    public function load(string $id): ?Game;
}