<?php

namespace BumpVersion\Tools;

use BumpVersion\Contracts\WriterContract;

class VersionWriter implements WriterContract
{
    /**
     * {@inheritDoc}
     */
    public function write(string $version): void
    {
        file_put_contents(filename: config('bump-version.file_path'),
                          data: $version);
    }
}
