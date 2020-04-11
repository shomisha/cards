<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Suites\Suite;

class SuiteTest extends TestCase
{
    /** @test */
    public function suite_can_instantiate_clubs()
    {
        $clubs = Suite::CLUBS();

        $this->assertInstanceOf(Suite::class, $clubs);
        $this->assertEquals('clubs', $clubs);
        $this->assertEquals('clubs', $clubs->name());
    }

    /** @test */
    public function suite_can_instantiate_diamonds()
    {
        $diamonds = Suite::DIAMONDS();

        $this->assertInstanceOf(Suite::class, $diamonds);
        $this->assertEquals('diamonds', $diamonds);
        $this->assertEquals('diamonds', $diamonds->name());
    }

    /** @test */
    public function suite_can_instantiate_hearts()
    {
        $hearts = Suite::HEARTS();

        $this->assertInstanceOf(Suite::class, $hearts);
        $this->assertEquals('hearts', $hearts);
        $this->assertEquals('hearts', $hearts->name());
    }

    /** @test */
    public function suite_can_instantiate_spades()
    {
        $spades = Suite::SPADES();

        $this->assertInstanceOf(Suite::class, $spades);
        $this->assertEquals('spades', $spades);
        $this->assertEquals('spades', $spades->name());
    }
}