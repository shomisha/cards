<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\Hand;

class InvalidSerializedHand extends \Exception
{
    public static function missingTypeKey(): self
    {
        return new self("The serialized hand is missing a 'type' key.");
    }

    public static function typeDoesNotExist(): self
    {
        return new self("The serialized hand 'type' does not exist.");
    }

    public static function typeIsNotHand(): self
    {
        return new self(sprintf("The serialized hand 'type' does not implement the %s interface.", Hand::class));
    }

    public static function missingCards(): self
    {
        return new self("The serialized hand is missing the 'cards' key");
    }

    public static function cardsNotAnArray(): self
    {
        return new self("The serialized hand 'cards' key is not an array.");
    }

    public static function invalidJson(): self
    {
        return new self("The serialized hand is not a valid JSON.");
    }
}