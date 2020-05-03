<?php

namespace Shomisha\Cards\Game;

use Shomisha\Cards\Contracts\Game\Hand;
use Shomisha\Cards\Contracts\Game\Player as PlayerContract;

class Player implements PlayerContract
{
    /** @var string */
    protected $name;

    /** @var Hand */
    protected $hand;

    public function __construct(string $name, Hand $hand = null)
    {
        $this->name = $name;
        $this->hand = $hand;
    }

    public function getHand(): ?Hand
    {
        return $this->hand;
    }

    public function setHand(Hand $hand): self
    {
        $this->hand = $hand;

        return $this;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}