<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Builders\Builder;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Suites\Suite;

class DeckTest extends TestCase
{
    /** @var \Shomisha\Cards\Contracts\Builder */
    protected $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = new Builder();
    }

    /** @test */
    public function deck_can_return_all_cards()
    {
        $deck = $this->builder->build();

        $cards = $deck->cards();

        $this->assertCount(52, $cards);
        $this->assertInstanceOf(Card::class, $cards[0]);

        // Assert that the cards will remain in the deck
        $this->assertEquals($cards, $deck->cards());
    }

    /** @test */
    public function deck_can_draw_the_first_card_from_the_stack()
    {
        $deck = $this->builder->build();
        $expectedCard = $deck->cards()[0];
        $this->assertCount(52, $deck->cards());


        $actualCard = $deck->draw();


        $this->assertEquals($expectedCard->identifier(), $actualCard->identifier());
        $this->assertCount(51, $deck->cards());
        $this->assertNotEquals($expectedCard->identifier(), $deck->cards()[0]);
        foreach ($deck->cards() as $card) {
            $this->assertNotEquals($expectedCard->identifier(), $card->identifier());
        }
    }

    /** @test */
    public function deck_can_place_a_card_on_top_of_the_stack()
    {
        $deck = $this->builder->build();
        $newCard = new Card(Suite::SPADES(), 10);
        $this->assertCount(52, $deck->cards());


        $deck->place($newCard);


        $this->assertCount(53, $deck->cards());
        $this->assertEquals($newCard->identifier(), $deck->cards()[0]->identifier());
    }

    /**
     * @test
     * @testWith [2]
     *           [24]
     *           [32]
     *           [42]
     */
    public function deck_can_take_a_card_from_a_specified_position($position)
    {
        $deck = $this->builder->build();
        $this->assertCount(52, $deck->cards());


        $takenCard = $deck->take($position);


        $this->assertCount(51, $deck->cards());
        $this->assertNotEquals($takenCard->identifier(), $deck->cards()[$position]->identifier());
        foreach ($deck->cards() as $card) {
            $this->assertNotEquals($takenCard->identifier(), $card->identifier());
        }
    }

    /**
     * @test
     * @testWith [1]
     *           [4]
     *           [32]
     *           [42]
     */
    public function deck_can_put_a_card_into_a_specified_position($position)
    {
        $deck = $this->builder->build();
        $this->assertCount(52, $deck->cards());
        $newCard = new Card(Suite::HEARTS(), 7);


        $deck->put($newCard, $position);


        $this->assertCount(53, $deck->cards());
        $this->assertEquals($newCard->identifier(), $deck->cards()[$position]->identifier());
    }
}