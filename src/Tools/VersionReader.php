<?php

namespace BumpVersion\Tools;

use BumpVersion\Contracts\ReaderContract;
use RuntimeException;

class VersionReader implements ReaderContract
{    
    /**
     * {@inheritDoc}
     */
    public function read(): string
    {
        // Configure the mode for reading the version number based on the configuration.
        $mode = config(key: 'bump-version.mode');

        return match($mode) {
            'json' => JSONReader::read(content: PlainReader::read()),
            'plain' => PlainReader::read(),
            default => throw new RuntimeException(message: "Unsupported mode: {$mode}. Please use 'json' or 'plain'."),
        };
    }
}
