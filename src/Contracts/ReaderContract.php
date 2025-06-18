<?php

namespace BumpVersion\Contracts;

interface ReaderContract
{
    /**
     * Read the current version from the version file.
     *
     * @return string The current version as a string.
     */
    public function read(): string;
}
