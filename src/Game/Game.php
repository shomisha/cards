<?php

namespace Shomisha\Cards\Game;

use Shomisha\Cards\Contracts\Deck as DeckContract;
use Shomisha\Cards\Contracts\Game\Board;
use Shomisha\Cards\Contracts\Game\Dealer;
use Shomisha\Cards\Contracts\Game\Game as GameContract;
use Shomisha\Cards\Contracts\Game\Message;
use Shomisha\Cards\Contracts\Game\Move;
use Shomisha\Cards\Contracts\Game\Player;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Exceptions\EndGameException;

abstract class Game implements GameContract
{
    /** @var \Shomisha\Cards\Contracts\Game\Board */
    protected $board;

    /** @var \Shomisha\Cards\Contracts\Game\Player[] */
    protected $players;

    /** @var \Shomisha\Cards\Decks\Deck */
    protected $deck;

    /** @var \Shomisha\Cards\Contracts\Game\Relay */
    protected $relay;

    protected $currentPlayerPosition = -1;

    abstract function prepareBoard(): Board;

    abstract function prepareDeck(): Deck;

    abstract function getDealer(): Dealer;

    abstract function determinePlayerOrder();

    abstract function validateMove(Move $move): void;

    abstract function hasEnded(): bool;

    abstract function canEnd(): bool;

    abstract function getNewMoveMessage(): Message;

    public function begin(): GameContract
    {
        $this->deck = $this->prepareDeck();

        $this->deal();

        $this->board = $this->prepareBoard();

        $this->determinePlayerOrder();

        $this->initiateNextMove();

        return $this;
    }

    public function advance(Move $move): GameContract
    {
        $this->validateMove($move);

        if ($move->hasPreApplicationEffects()) {
            $this->applyMoveEffects($move->getPreApplicationEffects());
        }

        try {
            $move->apply($this);
        } catch (EndGameException $e) {
            if ($this->canEnd()) {
                return $this->wrapUp();
            }
        }

        if ($move->hasPostApplicationEffects()) {
            $this->applyMoveEffects($move->getPostApplicationEffects());
        }

        if ($this->hasEnded()) {
            return $this->wrapUp();
        }

        $this->initiateNextMove();

        return $this;
    }

    public function players(): array
    {
        return $this->players;
    }

    public function currentPlayer(): ?Player
    {
        return $this->players[$this->currentPlayerPosition] ?? null;
    }

    public function nextPlayer(): Player
    {
        return $this->players[$this->guessNextPlayerPosition()];
    }

    public function board(): Board
    {
        return $this->board;
    }

    public function deck(): DeckContract
    {
        return $this->deck;
    }

    protected function deal(): self
    {
        $dealer = $this->getDealer();

        foreach ($this->players as $player) {
            $dealer->dealTo($player);
        }

        return $this;
    }

    protected function initiateNextMove(): void
    {
        $this->currentPlayerPosition = $this->guessNextPlayerPosition();

        $this->relay->notify($this->currentPlayer(), $this->getNewMoveMessage());
    }

    protected function guessNextPlayerPosition(): int
    {
        $nextIndex = $this->currentPlayerPosition + 1;

        if (isset($this->players[$nextIndex])) {
            return $nextIndex;
        }

        return 0;
    }

    /** @param \Shomisha\Cards\Contracts\Game\Effect[] $effects */
    protected function applyMoveEffects(array $effects): void
    {
        foreach ($effects as $effect) {
            $effect->apply($this);
        }
    }
}