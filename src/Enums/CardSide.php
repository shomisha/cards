<?php

namespace Shomisha\Cards\Enums;

class CardSide
{
    /** @var string */
    protected $side;

    public function side(): string
    {
        return $this->side;
    }

    public function __toString()
    {
        return $this->side;
    }

    public static function fromString(string $side): self
    {
        switch ($side) {
            case self::FACE_UP():
                return self::FACE_UP();
            case self::FACE_DOWN():
                return self::FACE_DOWN();
            default:
                throw new \InvalidArgumentException("Invalid card side: {$side}");
        }
    }

    public static function FACE_UP(): self
    {
        return new class extends CardSide
        {
            protected $side = 'face-up';
        };
    }

    public static function FACE_DOWN(): self
    {
        return new class extends CardSide
        {
            protected $side = 'face-down';
        };
    }
}