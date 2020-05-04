<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\Player;

class InvalidSerializedPlayer extends SerializationException
{
    protected static $serializes = 'player';

    public static function missingType(): self
    {
        return self::missingKey('type');
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
        return self::missingKey('name');
    }

    public static function nameNotString(): self
    {
        return self::keyNotType('name', 'string');
    }

    public static function missingHand(): self
    {
        return self::missingKey('hand');
    }

    public static function handNotArray(): self
    {
        return self::keyNotType('hand', 'array');
    }
}