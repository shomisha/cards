<?php

namespace Shomisha\Cards\Exceptions\Serialization;

class InvalidSerializedCard extends \Exception
{
    public static function missingIdKey(): self
    {
        return new self("The serialized card is missing the 'id' key.");
    }

    public static function idNotString(): self
    {
        return new self("The serialized card 'id' is not a string.");
    }

    public static function missingSuite(): self
    {
        return new static('The serialized card is missing a suite');
    }

    public static function invalidSuite(string $suite): self
    {
        return new static("Serialized card contains invalid suite: {$suite}");
    }

    public static function missingValue(): self
    {
        return new static('The serialized card is missing a value');
    }

    public static function invalidValue($value): self
    {
        return new static("The serialized card contains an invalid value: {$value}");
    }

    public static function invalidJson(): self
    {
        return new self("The serialized card is an invalid JSON.");
    }
}