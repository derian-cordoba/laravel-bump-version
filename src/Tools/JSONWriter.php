<?php

namespace BumpVersion\Tools;

use RuntimeException;

class JSONWriter
{
    public static function write(string $version, string $content): string
    {
        $data = json_decode(json: $content, associative: true);
        $data = data_set(target: $data,
                         key: config(key: 'bump-version.version_key'),
                         value: $version);

        $encoded = json_encode(value: $data, flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($encoded === false) {
            throw new RuntimeException(message: 'Failed to encode version data as JSON: ' . json_last_error_msg());
        }

        return $encoded;
    }
}
