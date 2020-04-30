<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\DeckBuilders\DeckBuilder;
use Shomisha\Cards\Game\EqualDealer;
use Shomisha\Cards\Game\Hand;
use Shomisha\Cards\Game\Player;

class EqualDealerTest extends TestCase
{
    /** @var \Shomisha\Cards\DeckBuilders\DeckBuilder */
    protected $builder;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->builder = new DeckBuilder();
    }

    /** @test */
    public function dealer_can_be_instantiated_with_deck()
    {
        $deck = $this->builder->build();


        $dealer = new EqualDealer($deck);


        $this->assertInstanceOf(EqualDealer::class, $dealer);
        $this->assertEquals($deck, $dealer->getDeck());
    }

    /** @test */
    public function dealer_can_be_instantiated_using_named_constructor()
    {
        $deck = $this->builder->build();


        $dealer = EqualDealer::fromDeck($deck);


        $this->assertInstanceOf(EqualDealer::class, $dealer);
        $this->assertEquals($deck, $dealer->getDeck());
    }

    /** @test */
    public function dealer_can_set_the_deck_for_dealing()
    {
        $dealer = new EqualDealer($this->builder->build());
        $dealer->getDeck()->draw();
        $this->assertCount(53, $dealer->getDeck()->getCards());
        $otherDeck = $this->builder->build();


        $dealer->using($otherDeck);


        $this->assertEquals($otherDeck, $dealer->getDeck());
    }

    /** @test */
    public function dealer_can_deal_cards_to_players()
    {
        $player = new Player('Misa');
        $this->assertNull($player->getHand());

        $dealer = new EqualDealer($this->builder->build(), 6);


        $dealer->dealTo($player);


        $this->assertInstanceOf(Hand::class, $player->getHand());
        $this->assertCount(6, $player->getHand()->getCards());
    }

    /**
     * @test
     * @testWith [3]
     *           [6]
     *           [18]
     */
    public function dealer_can_set_number_of_cards_per_player($perPlayer)
    {
        $player = new Player('Misa');
        $this->assertNull($player->getHand());

        $dealer = EqualDealer::fromDeck($this->builder->build());


        $dealer->perPlayer($perPlayer);
        $dealer->dealTo($player);


        $this->assertNotNull($player->getHand());
        $this->assertCount($perPlayer, $player->getHand()->getCards());
    }
}