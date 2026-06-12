<?php

namespace BumpVersion\Tools;

class PlainWriter
{
    public static function write(string $version, string $content): string
    {
        return $version;
    }
}
