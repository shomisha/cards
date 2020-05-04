<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\Board;

class InvalidSerializedBoard extends SerializationException
{
    protected static $serializes = 'board';

    public static function missingTypeKey(): self
    {
        return self::missingKey('type');
    }

    public static function typeDoesNotExist(): self
    {
        return new self("The serialized board 'type' does not exist.");
    }

    public static function typeNotBoard(): self
    {
        return new self(sprintf("The serialized board 'type' does not implement the %s interface.", Board::class));
    }

    public static function missingPositions(): self
    {
        return self::missingKey('positions');
    }

    public static function positionsNotAnArray(): self
    {
        return self::keyNotType('positions', 'array');
    }
}