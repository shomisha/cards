<?php

namespace Shomisha\Cards\Contracts\Game;

interface Board
{
    /**
     * Initialize all of the positions on the board.
     *
     * @return $this
     */
    public function initializePositions(): self;

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
    public function putOn(string $positionName, BoardPosition $position): self;
}