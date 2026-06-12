<?php

namespace Tests\Payloads;

class CustomReader
{
    public static function read(string $content): ?string
    {
        return str_replace(search: 'version=', replace: '', subject: $content);
    }
}
