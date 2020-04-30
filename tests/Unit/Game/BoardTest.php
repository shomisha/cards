<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Game\BoardPositions\CardBoardPosition;
use Shomisha\Cards\Game\Boards\Board;
use Shomisha\Cards\Tests\Traits\OverridesProtectedAccess;

class BoardTest extends TestCase
{
    use OverridesProtectedAccess;

    protected function getBoard()
    {
        return $this->getMockForAbstractClass(Board::class);
    }

    protected function getBoardWithPositions(array $positions)
    {
        $board = $this->getBoard();

        $this->setProtectedProperty($board, 'positions', $positions);

        return $board;
    }

    /** @test */
    public function board_can_return_positions()
    {
        $expectedPositions = [
            'first-position' => new CardBoardPosition(),
            'second-position' => new CardBoardPosition(),
        ];
        $board = $this->getBoardWithPositions($expectedPositions);


        $actualPositions = $board->getPositions();


        $this->assertEquals($expectedPositions, $actualPositions);
    }

    /** @test */
    public function board_can_return_specific_position()
    {
        $expectedPosition = new CardBoardPosition();
        $board = $this->getBoardWithPositions([
            'first-position' => $expectedPosition,
        ]);


        $actualPosition = $board->getPosition('first-position');


        $this->assertEquals($expectedPosition, $actualPosition);
    }

    /** @test */
    public function board_will_return_null_if_requested_position_doesnt_exist()
    {
        $board = $this->getBoard();


        $actualPosition = $board->getPosition('first-position');


        $this->assertNull($actualPosition);
    }

    /** @test */
    public function board_can_put_card_on_specific_board_position()
    {
        $board = $this->getBoard();
        $boardPosition = new CardBoardPosition();


        $board->putOn('first-position', $boardPosition);


        $this->assertEquals([
            'first-position' => $boardPosition
        ], $board->getPositions());
    }
}