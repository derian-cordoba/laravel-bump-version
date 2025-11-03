<?php

namespace BumpVersion\Tools;

class JSONWriter
{
    public static function write(string $version, string $content): string
    {
        $data = json_decode(json: $content, associative: true);
        $content = data_set(target: $data,
                            key: config(key: 'bump-version.version_key'),
                            value: $version);

        return json_encode(value: $content, flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
