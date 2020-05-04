<?php

namespace Shomisha\Cards\Exceptions\Serialization;

class SerializationException extends \Exception
{
    /** @var string */
    protected static $serializes;

    public static function missingIdKey(): self
    {
        return static::missingKey('id');
    }

    public static function idNotString(): self
    {
        return static::keyNotType('id', 'string');
    }

    public static function invalidJson(): self
    {
        $serializes = static::$serializes;

        return new static("The serialized {$serializes} is an invalid JSON.");
    }

    protected static function missingKey(string $key): self
    {
        $serializes = static::$serializes;

        return new static("The serialized {$serializes} is missing the '{$key}' key.");
    }

    protected static function keyNotType(string $key, string $type): self
    {
        $serializes = static::$serializes;

        return new static("The serialized {$serializes} '{$key}' is not a {$type}.");
    }
}