<?php

namespace Shomisha\Cards\Shufflers;

use Shomisha\Cards\Contracts\Deck;
use Shomisha\Cards\Contracts\Shuffler as ShufflerContract;

class Shuffler implements ShufflerContract
{
    public function shuffle(Deck $deck, int $rounds = 1): Deck
    {
        $cards = [];

        while (($card = $deck->draw()) !== null) {
            $cards[] = $card;
        }

        for ($i = 0; $i < $rounds; $i++) {
            shuffle($cards);
        }

        foreach ($cards as $card) {
            $deck->place($card);
        }
        
        return $deck;
    }
}