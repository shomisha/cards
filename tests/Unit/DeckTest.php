<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\DeckBuilders\DeckBuilder;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Suites\Suite;

class DeckTest extends TestCase
{
    /** @var \Shomisha\Cards\Contracts\DeckBuilder */
    protected $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = new DeckBuilder();
    }

    /** @test */
    public function deck_can_return_all_cards()
    {
        $deck = $this->builder->build();

        $cards = $deck->cards();

        $this->assertCount(54, $cards);
        $this->assertInstanceOf(Card::class, $cards[0]);

        // Assert that the cards will remain in the deck
        $this->assertEquals($cards, $deck->cards());
    }

    /** @test */
    public function deck_can_draw_the_first_card_from_the_stack()
    {
        $deck = $this->builder->build();
        $expectedCard = $deck->cards()[0];
        $this->assertCount(54, $deck->cards());


        $actualCard = $deck->draw();


        $this->assertEquals($expectedCard->identifier(), $actualCard->identifier());
        $this->assertCount(53, $deck->cards());
        $this->assertNotEquals($expectedCard->identifier(), $deck->cards()[0]);
        foreach ($deck->cards() as $card) {
            $this->assertNotEquals($expectedCard->identifier(), $card->identifier());
        }
    }

    /** @test */
    public function draw_will_return_null_if_no_cards_are_available()
    {
        $deck = new Deck([]);


        $drawn = $deck->draw();


        $this->assertNull($drawn);
    }

    /** @test */
    public function deck_can_place_a_card_on_top_of_the_stack()
    {
        $deck = $this->builder->build();
        $newCard = new Card(Suite::SPADES(), 10);
        $this->assertCount(54, $deck->cards());


        $deck->place($newCard);


        $this->assertCount(55, $deck->cards());
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
        $this->assertCount(54, $deck->cards());


        $takenCard = $deck->take($position);


        $this->assertCount(53, $deck->cards());
        $this->assertNotEquals($takenCard->identifier(), $deck->cards()[$position]->identifier());
        foreach ($deck->cards() as $card) {
            $this->assertNotEquals($takenCard->identifier(), $card->identifier());
        }
    }

    /** @test */
    public function take_will_return_null_if_the_requested_card_is_not_available()
    {
        $deck = $this->builder->build();


        $taken = $deck->take(55);


        $this->assertNull($taken);
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
        $this->assertCount(54, $deck->cards());
        $newCard = new Card(Suite::HEARTS(), 7);


        $deck->put($newCard, $position);


        $this->assertCount(55, $deck->cards());
        $this->assertEquals($newCard->identifier(), $deck->cards()[$position]->identifier());
    }

    /** @test */
    public function deck_can_be_split_to_two_controlled_decks()
    {
        $deck = (new DeckBuilder())->build();
        $this->assertCount(54, $deck->cards());
        $splitCard = $deck->peek(20);


        $split = $deck->split(20);


        $this->assertEquals($deck, $split[1]);
        $this->assertEquals($splitCard->identifier(), $split[1]->cards()[0]->identifier());
        $this->assertCount(34, $deck->cards());
        $this->assertCount(20, $split[0]->cards());
    }

    /** @test */
    public function deck_can_be_split_into_two_random_decks()
    {
        $deck = (new DeckBuilder())->build();
        $this->assertCount(54, $deck->cards());

        $split = $deck->split();

        $this->assertNotCount(54, $deck->cards());
        $this->assertNotEmpty($deck->cards());
        $this->assertNotCount(54, $split[0]->cards());
        $this->assertNotEmpty($split[0]->cards());
    }

    /** @test */
    public function deck_can_be_joined_using_another_deck()
    {
        $builder = new DeckBuilder();

        $deck1 = $builder->build();
        $this->assertCount(54, $deck1->cards());

        $deck2 = $builder->build();
        $this->assertCount(54, $deck2->cards());


        $deck1->join($deck2);

        $this->assertCount(108, $deck1->cards());
        $this->assertEmpty($deck2->cards());
    }
}