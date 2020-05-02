<?php

namespace Shomisha\Cards\Cards;

use Shomisha\Cards\Contracts\Card as CardContract;
use Shomisha\Cards\Contracts\Suite as SuiteContract;
use Shomisha\Cards\Enums\CardSide;
use Shomisha\Cards\Suites\Suite;

class FaceDownCard implements CardContract
{
    /** @var \Shomisha\Cards\Cards\Card */
    private $card;

    /** @var string */
    protected $side;

    public function __construct(CardContract $card, CardSide $side = null)
    {
        $this->card = $card;

        if ($side === null) {
            $side = CardSide::FACE_DOWN();
        }

        $this->side = $side;
    }

    public function isHidden()
    {
        return $this->side == CardSide::FACE_DOWN();
    }

    public function hide(): self
    {
        $this->side = CardSide::FACE_DOWN();

        return $this;
    }

    public function reveal(): self
    {
        $this->side = CardSide::FACE_UP();

        return $this;
    }

    public function rank(): string
    {
        if ($this->isHidden()) {
            return '*';
        }

        return $this->card->rank();
    }

    public function value(): string
    {
        if ($this->isHidden()) {
            return '*';
        }

        return $this->card->value();
    }

    public function suite(): SuiteContract
    {
        if ($this->isHidden()) {
            return Suite::HIDDEN();
        }

        return $this->card->suite();
    }

    public function identifier(): string
    {
        if ($this->isHidden()) {
            return '*';
        }

        return $this->card->identifier();
    }
}