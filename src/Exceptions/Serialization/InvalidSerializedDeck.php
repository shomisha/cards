<?php

namespace Shomisha\Cards\Exceptions\Serialization;

class InvalidSerializedDeck extends \Exception
{
    public static function missingIdKey()
    {
        return new self("The serialized deck is missing the 'id' key.");
    }

    public static function idNotString(): self
    {
        return new self("The serialized deck 'id' is not a string.");
    }

    public static function missingCards(): self
    {
        return new static("The serialized deck is missing the cards key.");
    }

    public static function cardsNotArray(): self
    {
        return new self("The serialized deck 'cards' is not an array.");
    }

    public static function invalidJson(): self
    {
        return new static("The serialized deck is an invalid JSON.");
    }
}