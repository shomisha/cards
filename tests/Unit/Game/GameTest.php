<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Contracts\Game\Relay;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Game\Boards\StackBoard;
use Shomisha\Cards\Game\Effect;
use Shomisha\Cards\Game\EqualDealer;
use Shomisha\Cards\Game\Game;
use Shomisha\Cards\Game\Hand;
use Shomisha\Cards\Game\Move;
use Shomisha\Cards\Game\Player;
use Shomisha\Cards\Suites\Suite;
use Shomisha\Cards\Tests\Traits\OverridesProtectedAccess;

class GameTest extends TestCase
{
    use OverridesProtectedAccess;

    protected function getGame(array $methods = [])
    {
        $mock = \Mockery::mock(sprintf(
            '%s[%s]',
            Game::class,
            implode(',', $methods)
        ));

        $mock->makePartial()->shouldAllowMockingProtectedMethods();

        return $mock;
    }

    protected function getGameWith(array $properties)
    {
        $game = $this->getGame();

        if ($properties['players'] ?? false) {
            $this->setProtectedProperty($game, 'players', $properties['players']);
        }

        if ($properties['board'] ?? false) {
            $this->setProtectedProperty($game, 'board', $properties['board']);
        }

        if ($properties['deck'] ?? false) {
            $this->setProtectedProperty($game, 'deck', $properties['deck']);
        }

        if ($properties['relay'] ?? false) {
            $this->setProtectedProperty($game, 'relay', $properties['relay']);
        }

        if (array_key_exists('currentPlayerPosition', $properties)) {
            $this->setProtectedProperty($game, 'currentPlayerPosition', $properties['currentPlayerPosition']);
        }

        return $game;
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function game_can_be_initialized()
    {
        $game = $this->getGame(['prepareDeck', 'deal', 'prepareBoard', 'determinePlayerOrder', 'initiateNextMove']);
        $prepareDeckExpectation = $game->shouldReceive('prepareDeck');
        $dealExpectation = $game->shouldReceive('deal');
        $prepareBoardExpectation = $game->shouldReceive('prepareBoard');
        $determinePlayerOrderExpectation = $game->shouldReceive('determinePlayerOrder');
        $initiateNextMove = $game->shouldReceive('initiateNextMove');


        $game->begin();


        $prepareDeckExpectation->verify();
        $dealExpectation->verify();
        $prepareBoardExpectation->verify();
        $determinePlayerOrderExpectation->verify();
        $initiateNextMove->verify();
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function game_can_advance_using_move()
    {
        $game = $this->getGame(['validateMove', 'initiateNextMove']);
        $move = \Mockery::mock(Move::class);

        $validateExpectation = $game->shouldReceive('validateMove')->with($move);
        $initiateNextMoveExpectation = $game->shouldReceive('initiateNextMove');

        $preEffectsExpectation = $move->shouldReceive('hasPreApplicationEffects')->andReturn(false);
        $applyExpectation = $move->shouldReceive('apply')->with($game);
        $postEffectsExpectation = $move->shouldReceive('hasPostApplicationEffects')->andReturn(false);


        $game->advance($move);


        $validateExpectation->verify();;
        $initiateNextMoveExpectation->verify();

        $preEffectsExpectation->verify();
        $applyExpectation->verify();
        $postEffectsExpectation->verify();
    }

    /**
     * @test
     * @doesNotPerformAssertions
     */
    public function game_will_apply_move_effects_when_advancing()
    {
        $game = $this->getGame(['validateMove', 'initiateNextMove']);
        $game->shouldReceive('validateMove');
        $game->shouldReceive('initiateNextMove');

        $move = \Mockery::mock(Move::class);
        $move->shouldReceive('apply');

        $preEffect = \Mockery::mock(Effect::class);
        $preEffectExpectation = $preEffect->shouldReceive('apply')->with($game);
        $move->shouldReceive('hasPreApplicationEffects')->andReturn(true);
        $move->shouldReceive('getPreApplicationEffects')->andReturn([$preEffect]);

        $postEffect = \Mockery::mock(Effect::class);
        $postEffectExpectation = $postEffect->shouldReceive('apply')->with($game);
        $move->shouldReceive('hasPostApplicationEffects')->andReturn(false);
        $move->shouldReceive('getPostApplicationEffects')->andReturn([$postEffect]);


        $game->advance($move);


        $preEffectExpectation->verify();
        $postEffectExpectation->verify();
    }

    /** @test */
    public function game_can_return_its_players()
    {
        $expectedPlayers = [
            new Player('Misa'),
            new Player('Stefan'),
            new Player('Ivana'),
        ];
        $game = $this->getGameWith([
            'players' => $expectedPlayers
        ]);


        $actualPlayers = $game->players();


        $this->assertEquals($expectedPlayers, $actualPlayers);
    }

    /**
     * @test
     * @testWith [0]
     *           [1]
     *           [2]
     */
    public function game_can_return_current_player($expectedPlayerPosition)
    {
        $players = [
            new Player('Misa'),
            new Player('Stefan'),
            new Player('Ivana'),
        ];
        $game = $this->getGameWith([
            'players' => $players,
            'currentPlayerPosition' => (int) $expectedPlayerPosition,
        ]);


        $actualPlayer = $game->currentPlayer();


        $this->assertEquals(
            $players[$expectedPlayerPosition],
            $actualPlayer
        );
    }

    /**
    * @test
    * @testWith [0, 1]
     *          [1, 2]
     *          [2, 0]
    **/
    public function game_can_guess_next_players_position($currentPosition, $expectedNextPosition)
    {
        $players = [
            new Player('Misa'),
            new Player('Stefan'),
            new Player('Ivana'),
        ];
        $game = $this->getGameWith([
            'players' => $players,
            'currentPlayerPosition' => $currentPosition,
        ]);


        $method = $this->getProtectedMethod($game, 'guessNextPlayerPosition');
        $actualNextPosition = $method->invoke($game);


        $this->assertEquals($expectedNextPosition, $actualNextPosition);
    }

    /**
    * @test
    * @testWith [0, 1]
     *          [1, 2]
     *          [2, 0]
    **/
    public function game_can_return_next_player($currentPlayerPosition, $expectedPlayerPosition)
    {
        $players = [
            new Player('Misa'),
            new Player('Stefan'),
            new Player('Ivana'),
        ];
        $game = $this->getGameWith([
            'players' => $players,
            'currentPlayerPosition' => $currentPlayerPosition
        ]);


        $actualNextPlayer = $game->nextPlayer();


        $this->assertEquals($players[$expectedPlayerPosition], $actualNextPlayer);
    }

    /** @test */
    public function game_can_initiate_next_move()
    {
        $players = [
            new Player('Misa'),
            new Player('Stefan'),
            new Player('Ivana'),
        ];

        $relay = \Mockery::mock(Relay::class);
        $notifyExpectation = $relay->shouldReceive('notify')->withAnyArgs();

        $game = $this->getGameWith([
            'relay' => $relay,
            'players' => $players,
            'currentPlayerPosition' => 1,
        ]);
        $newMoveMessageExpectation = $game->shouldReceive('getNewMoveMessage');


        $initiateMoveMethod = $this->getProtectedMethod($game, 'initiateNextMove');
        $initiateMoveMethod->invoke($game);


        $notifyExpectation->verify();
        $newMoveMessageExpectation->verify();
        $this->assertEquals($players[2], $game->currentPlayer());
    }

    /** @test */
    public function game_can_return_its_board()
    {
        $expectedBoard = new StackBoard([
            new Card(Suite::SPADES(), 13),
            new Joker(),
        ]);
        $game = $this->getGameWith([
            'board' => $expectedBoard,
        ]);


        $actualBoard = $game->board();


        $this->assertEquals($expectedBoard, $actualBoard);
    }

    /** @test */
    public function game_can_return_its_deck()
    {
        $expectedDeck = new Deck([
            new Joker(),
            new Card(Suite::HEARTS(), 13),
        ]);
        $game = $this->getGameWith([
            'deck' => $expectedDeck
        ]);


        $actualDeck = $game->deck();


        $this->assertEquals($expectedDeck, $actualDeck);
    }

    /** @test */
    public function game_can_deal_cards_to_its_players()
    {
        $deck = new Deck([
            $jackOfSpades = new Card(Suite::SPADES(), 12),
            $jackOfHearts = new Card(Suite::HEARTS(), 12),
            $jackOfDiamonds = new Card(Suite::DIAMONDS(), 12),
            $jackOfClubs = new Card(Suite::CLUBS(), 12),
        ]);
        $dealer = new EqualDealer($deck, 1);

        $players = [
            new Player('Misa'),
            new Player('Stefana'),
            new Player('Petar'),
            new Player('Dusan'),
        ];

        $game = $this->getGameWith([
            'deck' => $deck,
            'players' => $players,
        ]);
        $game->shouldReceive('getDealer')->andReturn($dealer);


        $game->deal();


        $this->assertEquals(
            new Hand([$jackOfSpades]),
            $players[0]->getHand()
        );
        $this->assertEquals(
            new Hand([$jackOfHearts]),
            $players[1]->getHand()
        );
        $this->assertEquals(
            new Hand([$jackOfDiamonds]),
            $players[2]->getHand()
        );
        $this->assertEquals(
            new Hand([$jackOfClubs]),
            $players[3]->getHand()
        );

        $this->assertEmpty($game->deck()->getCards());
    }
}