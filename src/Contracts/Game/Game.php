<?php

namespace Shomisha\Cards\Contracts\Game;

use Shomisha\Cards\Contracts\Deck;
use Shomisha\Cards\Contracts\Identifiable;

interface Game extends Identifiable
{
    /**
     * Initialize the game and initiate the first move.
     */
    public function begin();

    /**
     * Apply a move to the game, advance it and initiate the next move.
     *
     * @param \Shomisha\Cards\Contracts\Game\Move $move
     * @return mixed
     */
    public function advance(Move $move);

    /**
     * End the game.
     */
    public function wrapUp();

    /**
     * Return all the players involved in the game.
     *
     * @return \Shomisha\Cards\Contracts\Game\Player[]
     */
    public function players(): array;

    /**
     * Return the player who is currently on the move.
     *
     * @return \Shomisha\Cards\Contracts\Game\Player|null
     */
    public function currentPlayer(): ?Player;

    /**
     * Return the player whose move is next.
     *
     * @return \Shomisha\Cards\Contracts\Game\Player
     */
    public function nextPlayer(): Player;

    /**
     * Return the instance of the Board for this game.
     *
     * @return \Shomisha\Cards\Contracts\Game\Board
     */
    public function board(): Board;

    /**
     * Return the instance of the Deck for this game.
     *
     * @return \Shomisha\Cards\Contracts\Deck
     */
    public function deck(): Deck;
}