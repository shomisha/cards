<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Game\Hand;
use Shomisha\Cards\Game\Player;
use Shomisha\Cards\Suites\Suite;

class PlayerTest extends TestCase
{
    /** @test */
    public function player_can_be_instantiated()
    {
        $player = new Player('Misa');


        $this->assertEquals('Misa', $player->name());
        $this->assertNull($player->getHand());
    }

    /** @test */
    public function player_can_be_instantiated_with_hand()
    {
        $hand = new Hand();


        $player = new Player('Misa', $hand);


        $this->assertEquals($hand, $player->getHand());
    }

    /** @test */
    public function hand_can_be_added_to_player()
    {
        $player = new Player('Misa');
        $hand = new Hand();


        $player->setHand($hand);


        $this->assertEquals($hand, $player->getHand());
    }

    /** @test */
    public function new_hand_will_override_existing_hand()
    {
        $player = new Player('Misa', new Hand([new Joker()]));
        $newHand = new Hand([new Card(Suite::HEARTS(), 8)]);


        $player->setHand($newHand);


        $this->assertEquals($newHand, $player->getHand());
    }
}