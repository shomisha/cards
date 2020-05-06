<?php

namespace Shomisha\Cards\Game;

use Shomisha\Cards\Contracts\Game\Game;
use Shomisha\Cards\Contracts\Game\Move as MoveContract;
use Shomisha\Cards\Exceptions\EndGameException;

abstract class Move implements MoveContract
{
    /** @var \Shomisha\Cards\Contracts\Game\Effect[] */
    protected $preEffects = [];

    /** @var \Shomisha\Cards\Contracts\Game\Effect[] */
    protected $postEffects = [];

    abstract function apply(Game $game): void;

    public function getPreApplicationEffects(): array
    {
        return $this->createEffects($this->preEffects);
    }

    public function hasPreApplicationEffects(): bool
    {
        return !empty($this->preEffects);
    }

    public function getPostApplicationEffects(): array
    {
        return $this->createEffects($this->postEffects);
    }

    public function hasPostApplicationEffects(): bool
    {
        return !empty($this->postEffects);
    }

    protected function createEffects(array $effectClasses)
    {
        $effects = [];

        foreach ($effectClasses as $effectClass) {
            $effects[] = new $effectClass($this);
        }

        return $effects;
    }

    protected function requestGameEnd(string $message = null)
    {
        throw new EndGameException($message);
    }
}