<?php

namespace Shomisha\Cards\Game;

use Shomisha\Cards\Contracts\Game\Player as PlayerContract;

class Player implements PlayerContract
{
    /** @var string */
    protected $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}