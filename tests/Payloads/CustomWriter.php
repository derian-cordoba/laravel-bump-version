<?php

namespace Tests\Payloads;

class CustomWriter
{
    public static function write(string $version, string $content): string
    {
        return "version={$version}";
    }
}
