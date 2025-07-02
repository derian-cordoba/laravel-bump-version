<?php

namespace BumpVersion\Tools;

use RuntimeException;

class PlainReader
{
    public static function read(): string
    {
        $filePath = config(key: 'bump-version.file_path', default: 'version');

        // Check if the version file exists
        if (! file_exists(filename: $filePath)) {
            throw new RuntimeException(message: "Version file not found at path: {$filePath}. Please ensure the file exists or set a valid path in the configuration.");
        }

        return trim(string: file_get_contents(filename: $filePath));
    }
}
