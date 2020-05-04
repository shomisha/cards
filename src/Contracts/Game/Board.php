<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Identifiable;

interface Board extends Identifiable
{
    /**
     * Initialize all of the positions on the board.
     *
     * @return $this
     */
    public function initializePositions();

    /**
     * Get all of the available positions.
     *
     * @return \Shomisha\Cards\Contracts\Game\BoardPosition[]
     */
    public function getPositions(): array;

    /**
     * Get a specific board position.
     *
     * @param string $position
     * @return \Shomisha\Cards\Contracts\Game\BoardPosition|null
     */
    public function getPosition(string $position): ?BoardPosition;

    /**
     * Put a BoardPosition instance on a specific position.
     *
     * @param string $positionName
     * @param \Shomisha\Cards\Contracts\Game\BoardPosition $position
     * @return $this
     */
    public function putOn(string $positionName, BoardPosition $position);
}