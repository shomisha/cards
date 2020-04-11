<?php

namespace Shomisha\Cards\Tests\Unit;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Shomisha\Cards\DeckBuilders\DeckBuilder;
use Shomisha\Cards\Shufflers\Shuffler;

class ShufflerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @test */
    public function shuffler_can_shuffle_decks()
    {
        $shuffler = new Shuffler();
        $deck = (new DeckBuilder())->build();
        $oldCards = $deck->cards();
        $this->assertEquals($oldCards, $deck->cards());


        $shuffler->shuffle($deck);

        $this->assertCount(52, $deck->cards());
        $this->assertNotEquals($oldCards, $deck->cards());
    }

    /**
     * @test
     * @testWith [2]
     *           [4]
     *           [6]
     */
    public function shuffler_can_perform_multiple_rounds_of_shuffling($rounds)
    {
        $deck = (new DeckBuilder())->build();
        $mock = \Mockery::mock(sprintf('%s[performShuffle]', Shuffler::class));
        $mock->shouldAllowMockingProtectedMethods();
        $expectation = $mock->shouldReceive('performShuffle')->times($rounds);


        $mock->shuffle($deck, $rounds);


        $expectation->verify();
    }
}