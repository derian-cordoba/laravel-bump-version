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
        $filePath = config(key: 'bump-version.file_path', default: 'version');

        // Check if the version file exists, if not return the default version
        if (! file_exists(filename: $filePath)) {
            return config(key: 'bump-version.default_version');
        }

        // TODO: Implement the JSONReader and PlainReader to handle different file formats
        return trim(string: file_get_contents(filename: $filePath));
    }
}
