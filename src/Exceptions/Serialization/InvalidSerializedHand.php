<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\Hand;

class InvalidSerializedHand extends SerializationException
{
    protected static $serializes = 'card';

    public static function missingTypeKey(): self
    {
        return self::missingKey('type');
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
        return self::missingKey('cards');
    }

    public static function cardsNotAnArray(): self
    {
        return self::keyNotType('cards', 'array');
    }
}