<?php

namespace Shomisha\Cards\Game\Serializers\Board;

use Shomisha\Cards\Contracts\Game\Board;
use Shomisha\Cards\Contracts\Serializers\BoardSerializer;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedBoard;
use Shomisha\Cards\Game\Serializers\BoardPosition\ArrayBoardPositionSerializer;

class ArrayBoardSerializer implements BoardSerializer
{
    /** @var \Shomisha\Cards\Game\Serializers\BoardPosition\ArrayBoardPositionSerializer  */
    private $positionSerializer;

    public function __construct(ArrayBoardPositionSerializer $positionSerializer)
    {
        $this->positionSerializer = $positionSerializer;
    }

    public function serialize(Board $board)
    {
        $type = get_class($board);

        $positions = [];

        foreach ($board->getPositions() as $name => $position) {
            $positions[$name] = $this->positionSerializer->serialize($position);
        }

        return [
            'type' => $type,
            'positions' => $position,
        ];
    }

    public function unserialize($serialized): Board
    {
        $this->validateSerialized($serialized);

        /** @var \Shomisha\Cards\Contracts\Game\Board $board */
        $board = new $serialized['type'];

        foreach ($serialized['positions'] as $name => $position) {
            $board->putOn($name, $this->positionSerializer->unserialize($position));
        }

        return $board;
    }

    protected function validateSerialized(array $serialized)
    {
        if (!array_key_exists('type', $serialized)) {
            throw InvalidSerializedBoard::missingTypeKey();
        }

        if (!class_exists($serialized['type'])) {
            throw InvalidSerializedBoard::typeDoesNotExist();
        }

        if (!in_array(Board::class, class_implements($serialized['type']))) {
            throw InvalidSerializedBoard::typeNotBoard();
        }

        if (!array_key_exists('positions', $serialized)) {
            throw InvalidSerializedBoard::missingPositions();
        }

        if (!is_array($serialized['positions'])) {
            throw InvalidSerializedBoard::positionsNotAnArray();
        }
    }
}