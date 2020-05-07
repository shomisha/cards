<?php

namespace Shomisha\Cards\Contracts\Game\Repositories;

use Shomisha\Cards\Contracts\Deck;

interface DeckRepository
{
    /**
     * Persist an instance of Deck and return its id.
     * This method should perform an upsert operation.
     *
     * @param \Shomisha\Cards\Contracts\Deck $deck
     * @return string
     */
    public function save(Deck $deck): string;

    /**
     * Load an instance of Deck based on its id.
     *
     * @param string $id
     * @return \Shomisha\Cards\Contracts\Deck|null
     */
    public function load(string $id): ?Deck;
}