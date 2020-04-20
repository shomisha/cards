<?php

namespace Shomisha\Cards\Game\BoardPositions;

use Shomisha\Cards\Contracts\Card;
use Shomisha\Cards\Contracts\Game\BoardPosition;

class StackBoardPosition implements BoardPosition
{
    /** @var \Shomisha\Cards\Game\BoardPositions\CardBoardPosition[] */
    protected $stack = [];
    
    public function isEmpty(): bool
    {
        return empty($this->stack);
    }
    
    public function topCard(): ?BoardPosition
    {
        return $this->stack[0];
    }

    public function put(Card $card): self
    {
        array_unshift($this->stack, $card);
    }

    public function take(Card $card): self
    {
        array_shift($this->stack);
    }
    
    public function isRevealed(): bool
    {
        if ($this->isEmpty()) {
            return true;
        }
        
        return $this->topCard()->isRevealed();
    }

    public function reveal(): ?Card
    {
        if ($this->isEmpty()) {
            return null;
        }
        
        return $this->topCard()->reveal();
    }

    public function hide(): void
    {
        if (!$this->isEmpty()) {
            $this->topCard()->hide();
        }
    }

    public function putCard(Card $card): BoardPosition
    {
        array_unshift($this->stack, new CardBoardPosition($card));
    }

    public function takeCard(): ?Card
    {
        return array_shift($this->stack)->takeCard();
    }

    public function peek(): ?Card
    {
        if ($this->isEmpty()) {
            return null;
        }
        
        return $this->topCard()->peek();
    }
}