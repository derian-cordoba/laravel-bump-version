<?php

namespace BumpVersion\Tools;

class JSONReader
{
    public static function read(string $content): string
    {
        return data_get(target: json_decode(json: $content, associative: true),
                        key: config(key: 'bump-version.version_key'));
    }
}
