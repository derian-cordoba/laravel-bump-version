<?php

namespace BumpVersion\Tools;

use BumpVersion\Contracts\ReaderContract;

class VersionReader implements ReaderContract
{
    /**
     * {@inheritDoc}
     */
    public function read(): string
    {
        return file_get_contents(filename: config('bump-version.file_path'));
    }
}
