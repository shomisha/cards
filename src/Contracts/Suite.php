<?php

namespace Shomisha\Cards\Contracts;

interface Suite
{
    /**
     * The name of the suite.
     *
     * @return string
     */
    public function name(): string;
}