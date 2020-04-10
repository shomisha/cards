<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Builders\Builder;
use Shomisha\Cards\Decks\Deck;

class BuilderTest extends TestCase
{
    /** @test */
    public function builder_can_build_a_deck()
    {
        $builder = new Builder();

        $deck = $builder->build();

        $this->assertInstanceOf(Deck::class, $deck);
    }

    /** @test */
    public function built_deck_will_have_all_cards()
    {
        $expectedCards = [];
        foreach (['clubs', 'diamonds', 'hearts', 'spades'] as $suite) {
            $expectedCards = array_merge($expectedCards, [
                "{$suite}-1",
                "{$suite}-2",
                "{$suite}-3",
                "{$suite}-4",
                "{$suite}-5",
                "{$suite}-6",
                "{$suite}-7",
                "{$suite}-8",
                "{$suite}-9",
                "{$suite}-10",
                "{$suite}-12",
                "{$suite}-13",
                "{$suite}-14",
            ]);
        }
        $builder = new Builder();


        $deck = $builder->build();
        $actualCards = $deck->cards();


        $this->assertEquals(count($expectedCards), count($actualCards));
        foreach ($actualCards as $card) {
            $this->assertTrue(in_array($card->identifier(), $expectedCards));
        }
    }
}