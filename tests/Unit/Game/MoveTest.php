<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Game\Move;
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
}