<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\BoardPosition;

class InvalidSerializedBoardPosition extends SerializationException
{
    protected static $serializes = 'board position';

    public static function missingTypeKey(): self
    {
        return self::missingKey('type');
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
        return self::missingKey('cards');
    }

    public static function cardsIsNotAnArray(): self
    {
        return self::keyNotType('cards', 'array');
    }
}