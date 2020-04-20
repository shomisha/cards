<?php

namespace Shomisha\Cards\Game;

use Shomisha\Cards\Contracts\Deck;
use Shomisha\Cards\Contracts\Game\Dealer;
use Shomisha\Cards\Contracts\Game\Player;

class EqualDealer implements Dealer
{
    /** @var Deck */
    private $deck;

    /** @var int|null */
    protected $perPlayer;

    public function __construct(int $perPlayer)
    {
        $this->perPlayer = $perPlayer;
    }

    public function using(Deck $deck): Dealer
    {
        $this->deck = $deck;

        return $this;
    }

    public function dealTo(Player $player): Dealer
    {
        for ($i = 0; $i < $this->perPlayer; $i++) {
            $card = $this->deck->draw();

            // TODO: add card to players hand
        }

        return $this;
    }

    public function perPlayer(int $perPlayer): self
    {
        $this->perPlayer = $perPlayer;

        return $this;
    }
}