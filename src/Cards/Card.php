<?php

namespace Shomisha\Cards\Cards;

use Shomisha\Cards\Contracts\Card as CardContract;
use Shomisha\Cards\Contracts\Suite;
use Shomisha\Cards\Traits\Identifiable;

class Card implements CardContract
{
    use Identifiable;

    /** @var string */
    private $rank;

    /** @var int */
    private $value;

    /** @var string */
    private $suite;

    public function rank(): string
    {
        return $this->rank;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function suite(): Suite
    {
        return $this->suite;
    }

    public function identifier(): string
    {
        return "{$this->suite}-{$this->value}";
    }

    public function __construct(Suite $suite, int $value)
    {
        $this->suite = $suite;
        $this->value = $value;
        $this->rank = CardContract::RANKS[$value];
    }
}