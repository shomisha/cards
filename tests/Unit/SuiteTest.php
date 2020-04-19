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

    /** @test */
    public function suite_can_instantiate_jokers()
    {
        $joker = Suite::JOKER();

        $this->assertInstanceOf(Suite::class, $joker);
        $this->assertEquals('joker', $joker);
        $this->assertEquals('joker', $joker->name());
    }

    public function suiteNamesMap():array
    {
        return [
            ['clubs', Suite::CLUBS()],
            ['diamonds', Suite::DIAMONDS()],
            ['hearts', Suite::HEARTS()],
            ['spades', Suite::SPADES()],
            ['joker', Suite::JOKER()],
        ];
    }

    /**
    * @test
    * @dataProvider suiteNamesMap
    **/
    public function suite_can_be_instantiated_by_suite_name($name, $expectedSuite)
    {
        $actualSuite = Suite::fromString($name);

        $this->assertInstanceOf(Suite::class, $actualSuite);
        $this->assertEquals($expectedSuite, $actualSuite);
    }
}