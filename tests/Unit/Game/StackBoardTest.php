<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Game\BoardPositions\StackBoardPosition;
use Shomisha\Cards\Game\Boards\StackBoard;
use Shomisha\Cards\Suites\Suite;

class StackBoardTest extends TestCase
{
    /** @test */
    public function stack_board_will_have_only_one_position()
    {
        $board = new StackBoard();


        $positions = $board->getPositions();


        $this->assertCount(1, $positions);
        $this->assertInstanceOf(StackBoardPosition::class, $positions['stack']);
    }

    /** @test */
    public function stack_board_can_be_instantiated_with_cards()
    {
        $cards = [
            new Card(Suite::HEARTS(), 12),
            new Card(Suite::SPADES(), 7)
        ];
        $board = new StackBoard($cards);


        $boardCards = $board->getStack()->getCards();


        $this->assertCount(2, $boardCards);
        $this->assertEquals($boardCards[0]->identifier(), $cards[0]->identifier());
        $this->assertEquals($boardCards[1]->identifier(), $cards[1]->identifier());
    }

    /** @test */
    public function stack_board_can_return_its_underlying_stack_position()
    {
        $board = new StackBoard();


        $stackPosition = $board->getStack();


        $this->assertInstanceOf(StackBoardPosition::class, $stackPosition);
    }
}
