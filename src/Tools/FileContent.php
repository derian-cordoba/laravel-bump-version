<?php

namespace BumpVersion\Tools;

use RuntimeException;

class FileContent
{
    public static function read(): string
    {
        $filePath = config(key: 'bump-version.file_path', default: base_path(path: 'composer.json'));

        if (! file_exists(filename: $filePath)) {
            return config()->string(key: 'bump-version.default_version',
                                    default: '0.0.0');
        }

        $content = file_get_contents(filename: $filePath);

        if ($content === false) {
            throw new RuntimeException(message: "Failed to read version file: '$filePath'.");
        }

        return trim(string: $content);
    }
}
