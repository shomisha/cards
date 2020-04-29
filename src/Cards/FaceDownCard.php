<?php

namespace Shomisha\Cards\Cards;

use Shomisha\Cards\Contracts\Card as CardContract;
use Shomisha\Cards\Contracts\Suite as SuiteContract;
use Shomisha\Cards\Suites\Suite;

class FaceDownCard implements CardContract
{
    const FACE_UP = 'face-up';
    const FACE_DOWN = 'face-down';

    /** @var \Shomisha\Cards\Cards\Card */
    private $card;

    /** @var string */
    protected $side;

    public function __construct(Card $card, string $side = self::FACE_UP)
    {
        $this->card = $card;

        if (!in_array($side, [self::FACE_UP, self::FACE_DOWN])) {
            throw new \InvalidArgumentException("Invalid card side: {$side}");
        }

        $this->side = $side;
    }

    public function isHidden()
    {
        return $this->side === self::FACE_DOWN;
    }

    public function hide(): self
    {
        $this->side = self::FACE_DOWN;

        return $this;
    }

    public function reveal(): self
    {
        $this->side = self::FACE_UP;

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
    }

    public function identifier(): string
    {
        if ($this->isHidden()) {
            return '*';
        }

        return $this->card->identifier();
    }
}