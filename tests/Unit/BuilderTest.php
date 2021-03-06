<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\DeckBuilders\DeckBuilder;
use Shomisha\Cards\Decks\Deck;

class BuilderTest extends TestCase
{
    /** @test */
    public function builder_can_build_a_deck()
    {
        $builder = new DeckBuilder();

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
        $expectedCards = array_merge($expectedCards, [
            'joker',
            'joker',
        ]);

        $builder = new DeckBuilder();


        $deck = $builder->build();
        $actualCards = $deck->cards();


        $this->assertEquals(count($expectedCards), count($actualCards));
        foreach ($actualCards as $card) {
            $this->assertTrue(in_array($card->identifier(), $expectedCards));
        }
    }

    /**
     * @test
     * @testWith [2]
     *           [4]
     *           [6]
     */
    public function builder_can_build_decks_that_consist_of_multiple_decks($count)
    {
        $builder = new DeckBuilder();


        $multiDeck = $builder->buildMultiple($count);


        $this->assertCount(54 * $count, $multiDeck->cards());
    }

    /** @test */
    public function multi_decks_will_have_the_same_number_of_repetitions_for_each_card()
    {
        $builder = new DeckBuilder();


        $multiDeck = $builder->buildMultiple(3);


        $cards = $multiDeck->cards();
        $groupedByIdentifier = [];
        $jokers = 0;
        foreach ($cards as $card) {
            if ($card instanceof Joker) {
                $jokers++;

                continue;
            }

            $groupedByIdentifier[$card->identifier()][] = $card;
        }
        
        foreach ($groupedByIdentifier as $group) {
            $this->assertCount(3, $group);
        }
        $this->assertEquals(6, $jokers);
    }

    /** @test */
    public function builder_can_build_decks_without_jokers()
    {
        $builder = (new DeckBuilder())->withJokers(false);


        $deck = $builder->build();


        $cards = $deck->cards();
        $this->assertCount(52, $cards);
        $this->assertNotContains('joker', array_map(function (Card $card) { return $card->identifier(); }, $cards));
    }

    /** @test */
    public function builder_can_build_multi_decks_without_jokers()
    {
        $builder = (new DeckBuilder())->withJokers(false);


        $deck = $builder->buildMultiple(3);


        $cards = $deck->cards();
        $this->assertCount(156, $cards);
        $this->assertNotContains('joker', array_map(function (Card $card) { return $card->identifier(); }, $cards));
    }
}