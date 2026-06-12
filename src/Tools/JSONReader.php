<?php

namespace BumpVersion\Tools;

use Illuminate\Support\Facades\Log;

class JSONReader
{
    public static function read(string $content): ?string
    {
        $data = json_decode(json: $content, associative: true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error(message: 'JSON decode fails',
                       context: ['error' => json_last_error_msg(), 'content' => $content]);

            return null;
        }

        return data_get(target: $data,
                        key: config(key: 'bump-version.version_key'));
    }
}
