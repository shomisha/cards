<?php

namespace Shomisha\Cards\Exceptions;

class InvalidSerializedCard extends \Exception
{
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