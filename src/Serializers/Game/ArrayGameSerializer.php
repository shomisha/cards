<?php

namespace Shomisha\Cards\Serializers\Game;

use Shomisha\Cards\Contracts\Deck;
use Shomisha\Cards\Contracts\Game\Board;
use Shomisha\Cards\Contracts\Game\Game;
use Shomisha\Cards\Contracts\Serializers\GameSerializer;
use Shomisha\Cards\Serializers\Board\ArrayBoardSerializer;
use Shomisha\Cards\Serializers\Deck\ArrayDeckSerializer;
use Shomisha\Cards\Serializers\Player\ArrayPlayerSerializer;

abstract class ArrayGameSerializer implements GameSerializer
{
    /** @var \Shomisha\Cards\Serializers\Board\ArrayBoardSerializer  */
    protected $boardSerializer;

    /** @var \Shomisha\Cards\Serializers\Player\ArrayPlayerSerializer  */
    protected $playerSerializer;

    /** @var \Shomisha\Cards\Serializers\Deck\ArrayDeckSerializer  */
    protected $deckSerializer;

    public function __construct(
        ArrayBoardSerializer $boardSerializer,
        ArrayPlayerSerializer $playerSerializer,
        ArrayDeckSerializer $deckSerializer
    )
    {
        $this->boardSerializer = $boardSerializer;
        $this->playerSerializer = $playerSerializer;
        $this->deckSerializer = $deckSerializer;
    }

    protected function serializeBoard(Board $board): array
    {
        return $this->boardSerializer->serialize($board);
    }

    /** @param array|\Shomisha\Cards\Contracts\Game\Player[] $players */
    protected function serializePlayers(array $players): array
    {
        return array_map(function (array $player) {
            return $this->playerSerializer->serialize($player);
        }, $players);
    }

    protected function serializeDeck(Deck $deck): array
    {
        return $this->deckSerializer->serialize($deck);
    }

    abstract function performSerialize(array $board, array $players, array $deck, string $id): array;

    public function serialize(Game $game)
    {
        $board = $this->serializeBoard($game->board());
        $players = $this->serializePlayers($game->players());
        $deck = $this->serializeDeck($game->deck());

        return $this->performSerialize($board, $players, $deck, $game->getId());
    }
}