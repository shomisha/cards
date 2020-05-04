<?php

namespace Shomisha\Cards\Exceptions\Serialization;

class InvalidSerializedDeck extends SerializationException
{
    protected static $serializes = 'deck';

    public static function missingCards(): self
    {
        return self::missingKey('cards');
    }

    public static function cardsNotArray(): self
    {
        return self::keyNotType('cards', 'array');
    }
}