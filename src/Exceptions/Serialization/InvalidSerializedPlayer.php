<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\Player;

class InvalidSerializedPlayer extends \Exception
{
    public static function missingType(): self
    {
        return new self("The serialized player is missing a 'type' key.");
    }

    public static function typeDoesNotExist(): self
    {
        return new self("The serialized player 'type' does not exist.");
    }

    public static function typeNotPlayer(): self
    {
        return new self(sprintf("The serialized player 'type' does not implement the %s interface.", Player::class));
    }

    public static function missingName(): self
    {
        return new self("The serialized player is missing the 'name' key.");
    }

    public static function nameNotString(): self
    {
        return new self("The serialized player 'name' is not a string.");
    }

    public static function missingHand(): self
    {
        return new self("The serialized player is missing the 'hand' key.");
    }

    public static function handNotArray(): self
    {
        return new self("The serialized player 'hand' is not an array.");
    }

    public static function invalidJson(): self
    {
        return new self("The serialized player is an invalid JSON.");
    }
}