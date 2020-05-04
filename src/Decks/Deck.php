<?php

namespace Shomisha\Cards\Decks;

use Shomisha\Cards\CardGroups\CardStack;
use Shomisha\Cards\Contracts\Deck as DeckContract;
use Shomisha\Cards\Traits\Identifiable;

class Deck extends CardStack implements DeckContract
{
    use Identifiable;

    public function split(int $position = -1): array
    {
        if ($position == -1) {
            $position = random_int(1, count($this->getCards())) - 1;
        }

        $split = array_slice($this->cards, 0, $position);
        $this->cards = array_slice($this->cards, $position);

        return [
            new Deck($split),
            $this
        ];
    }

    public function join(DeckContract $otherDeck): DeckContract
    {
        while ($card = $otherDeck->draw()) {
            $this->place($card);
        }

        return $this;
    }
}