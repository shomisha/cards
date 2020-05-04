<?php

namespace Shomisha\Cards\Exceptions\Serialization;

class InvalidSerializedCard extends SerializationException
{
    protected static $serializes = 'card';

    public static function missingSuite(): self
    {
        return self::missingKey('suite');
    }

    public static function invalidSuite(string $suite): self
    {
        return new static("Serialized card contains invalid suite: {$suite}");
    }

    public static function missingValue(): self
    {
        return self::missingKey('value');
    }

    public static function invalidValue($value): self
    {
        return new static("The serialized card contains an invalid value: {$value}");
    }
}