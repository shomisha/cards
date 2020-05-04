<?php

namespace Shomisha\Cards\Traits;

use Ramsey\Uuid\Uuid;

trait Identifiable
{
    /** @var string */
    protected $id;

    public function getId(): string
    {
        if (!$this->id) {
            $this->id = Uuid::uuid4();
        }

        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;

        return $this;
    }
}