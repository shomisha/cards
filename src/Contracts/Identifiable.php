<?php

namespace Shomisha\Cards\Contracts;

interface Identifiable
{
    /**
     * Get a value used to uniquely identify the given instance.
     *
     * @return string
     */
    public function getId(): string;

    /** Set a unioque ID on the given instance.
     *
     * @param string $id
     */
    public function setId(string $id);
}