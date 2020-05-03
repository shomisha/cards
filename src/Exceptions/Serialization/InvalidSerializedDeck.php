<?php

namespace Shomisha\Cards\Exceptions\Serialization;

class InvalidSerializedDeck extends \Exception
{
    public static function missingCards(): self
    {
        return new static("The serialized deck is missing the cards key.");
    }

    public static function invalidJson(): self
    {
        return new static("The serialized deck is an invalid JSON.");
    }
}