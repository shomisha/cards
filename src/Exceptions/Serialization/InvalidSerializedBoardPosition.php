<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\BoardPosition;

class InvalidSerializedBoardPosition extends \Exception
{
    public static function missingTypeKey(): self
    {
        return new self("The serialized board position is missing a 'type' key.");
    }

    public static function typeDoesNotExist(): self
    {
        return new self("The serialized board position 'type' does not exist.");
    }

    public static function typeNotBoardPosition(): self
    {
        return new self(sprintf("The serialized board position class does not implement the %s interface.", BoardPosition::class));
    }

    public static function missingCardsKey(): self
    {
        return new self("The serialized value is missing a 'cards' key.");
    }

    public static function cardsIsNotAnArray(): self
    {
        return new self("The 'cards' serialized value is not an array.");
    }

    public static function invalidJson(): self
    {
        return new self("The serialized value is an invalid JSON.");
    }
}