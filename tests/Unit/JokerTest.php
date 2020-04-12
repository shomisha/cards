<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Joker;

class JokerTest extends TestCase
{
    /** @test */
    public function joker_will_have_the_right_rank()
    {
        $joker = new Joker();

        $rank = $joker->rank();

        $this->assertEquals('joker', $rank);
    }

    /** @test */
    public function joker_will_have_the_right_value()
    {
        $joker = new Joker();

        $value = $joker->value();

        $this->assertEquals(15, $value);
    }

    /** @test */
    public function joker_will_have_the_right_suite()
    {
        $joker = new Joker();

        $suite = $joker->suite();

        $this->assertEquals('joker', $suite);
    }
}