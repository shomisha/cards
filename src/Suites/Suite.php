<?php

namespace Shomisha\Cards\Suites;

use Shomisha\Cards\Contracts\Suite as SuiteContract;

class Suite implements SuiteContract
{
    /** @var string */
    protected $name;

    public function name(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Instantiate a clubs suite
     *
     * @return \Shomisha\Cards\Suites\Suite
     */
    public static function CLUBS(): Suite
    {
        return new class extends Suite
        {
            protected $name = 'clubs';
        };
    }

    /**
     * Instantiate a diamonds suite
     *
     * @return \Shomisha\Cards\Suites\Suite
     */
    public static function DIAMONDS(): Suite
    {
        return new class extends Suite
        {
            protected $name = 'diamonds';
        };
    }

    /**
     * Instantiate a hearts suite
     *
     * @return \Shomisha\Cards\Suites\Suite
     */
    public static function HEARTS(): Suite
    {
        return new class extends Suite
        {
            protected $name = 'hearts';
        };
    }

    /**
     * Instantiate a spades suite
     *
     * @return \Shomisha\Cards\Suites\Suite
     */
    public static function SPADES(): Suite
    {
        return new class extends Suite
        {
            protected $name = 'spades';
        };
    }

    /**
     * Return instances of all available suites.
     *
     * @return \Shomisha\Cards\Suites\Suite[]
     */
    public static function all(): array
    {
        return [
            self::CLUBS(),
            self::DIAMONDS(),
            self::HEARTS(),
            self::SPADES(),
        ];
    }
}