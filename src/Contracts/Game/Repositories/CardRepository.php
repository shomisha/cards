<?php

namespace Shomisha\Cards\Contracts\Game\Repositories;

use Shomisha\Cards\Contracts\Card;

interface CardRepository
{
    /**
     * Persist an instance of Card and return its id.
     * This method should perform an upsert operation.
     *
     * @param \Shomisha\Cards\Contracts\Card $card
     * @return string
     */
    public function save(Card $card): string;

    /**
     * Load an instance of Card based on its id.
     *
     * @param string $id
     * @return \Shomisha\Cards\Contracts\Card|null
     */
    public function load(string $id): ?Card;
}