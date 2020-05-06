<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Exceptions\EndGameException;
use Shomisha\Cards\Game\Move;
use Shomisha\Cards\Tests\Fakes\FakeMoveEffect;
use Shomisha\Cards\Tests\Traits\OverridesProtectedAccess;

class MoveTest extends TestCase
{
    use OverridesProtectedAccess;

    protected function getMove()
    {
        return $this->getMockForAbstractClass(Move::class);
    }

    protected function getMoveWithEffects(array $effects)
    {
        $move = $this->getMove();

        if ($effects['pre'] ?? false) {
            $this->setProtectedProperty($move, 'preEffects', $effects['pre']);
        }

        if ($effects['post'] ?? false) {
            $this->setProtectedProperty($move, 'postEffects', $effects['post']);
        }

        return $move;
    }

    /**
     * @test
     * @testWith [true]
     *           [false]
     */
    public function move_can_check_if_it_has_pre_application_effects($expectedHasEffects)
    {
        $effects = ($expectedHasEffects)
            ? ['test-effect-1', 'test-effect-2']
            : [];
        $move = $this->getMoveWithEffects([
            'pre' => $effects,
        ]);


        $actualHasEffects = $move->hasPreApplicationEffects();


        $this->assertEquals($expectedHasEffects, $actualHasEffects);
    }

    /** @test */
    public function move_can_return_pre_application_effects()
    {
        $move = $this->getMoveWithEffects(['pre' => [FakeMoveEffect::class]]);


        $effects = $move->getPreApplicationEffects();


        $this->assertCount(1, $effects);
        $this->assertInstanceOf(FakeMoveEffect::class, $effects[0]);
    }

    /** @test */
    public function move_will_not_mix_pre_and_post_application_effects()
    {
        $move = $this->getMoveWithEffects([
            'pre' => [FakeMoveEffect::class],
            'post' => [FakeMoveEffect::class, FakeMoveEffect::class],
        ]);


        $effects = $move->getPreApplicationEffects();


        $this->assertCount(1, $effects);
    }

    /**
    * @test
    * @testWith [true]
     *          [false]
    **/
    public function move_can_check_if_it_has_post_application_effects($expectedHasEffects)
    {
        $effects = ($expectedHasEffects)
            ? ['test-effect-1', 'test-effect-2']
            : [];
        $move = $this->getMoveWithEffects([
            'post' => $effects,
        ]);


        $actualHasEffects = $move->hasPostApplicationEffects();


        $this->assertEquals($expectedHasEffects, $actualHasEffects);
    }

    /** @test */
    public function move_can_return_post_application_effects()
    {
        $move = $this->getMoveWithEffects(['post' => [FakeMoveEffect::class]]);


        $effects = $move->getPostApplicationEffects();


        $this->assertCount(1, $effects);
        $this->assertInstanceOf(FakeMoveEffect::class, $effects[0]);
    }

    /** @test */
    public function move_can_request_game_end()
    {
        $move = $this->getMove();
        $this->expectException(EndGameException::class);


        $method = $this->getProtectedMethod($move, 'requestGameEnd');
        $method->invoke($move);
    }
}