<?php

namespace Shomisha\Cards\Exceptions\Serialization;

use Shomisha\Cards\Contracts\Game\Board;

class InvalidSerializedBoard extends \Exception
{
    public static function missingIdKey(): self
    {
        return new self("The serialized board is missing the 'id' key.");
    }

    public static function idNotString(): self
    {
        return new self("The serialized board 'id' is not a string.");
    }

    public static function missingTypeKey(): self
    {
        return new self("The serialized board is missing a 'type' key.");
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
        return new self("The serialized board is missing positions.");
    }

    public static function positionsNotAnArray(): self
    {
        return new self("The serialized board 'positions' key does not contain an array.");
    }

    public static function invalidJson(): self
    {
        return new self("The serialized board is an invalid JSON.");
    }
}