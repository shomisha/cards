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

    public function __construct(Deck $deck, int $perPlayer = null)
    {
        $this->deck = $deck;
        $this->perPlayer = $perPlayer;
    }

    public static function fromDeck(Deck $deck)
    {
        return new self($deck);
    }

    public function using(Deck $deck): Dealer
    {
        $this->deck = $deck;

        return $this;
    }

    public function getDeck(): Deck
    {
        return $this->deck;
    }

    public function dealTo(Player $player): Dealer
    {
        $player->setHand($this->prepareHand());

        return $this;
    }

    public function perPlayer(int $perPlayer): self
    {
        $this->perPlayer = $perPlayer;

        return $this;
    }

    protected function prepareHand(): Hand
    {
        $cards = [];

        for ($i = 0; $i < $this->perPlayer; $i++) {
            $cards[] = $this->deck->draw();
        }

        return new Hand($cards);
    }
}