<?php

namespace BumpVersion\Contracts;

interface WriterContract
{
    /**
     * Write the new version to a file.
     *
     * @param string $version The version to write.
     */
    public function write(string $version): void;
}
