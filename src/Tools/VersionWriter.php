<?php

namespace BumpVersion\Tools;

use BumpVersion\Contracts\ReaderContract;
use BumpVersion\Contracts\WriterContract;
use RuntimeException;

class VersionWriter implements WriterContract
{
    private readonly string $mode;
    private readonly string $content;

    public function __construct()
    {
        $this->mode = config(key: 'bump-version.mode');
        $this->content = PlainReader::read();
    }

    /**
     * {@inheritDoc}
     */
    public function write(string $version): void
    {
        // Generate content based on mode
        $content = match($this->mode) {
            'json' => JSONWriter::write(version: $version, content: $this->content),
            'xml' => XMLWriter::write(version: $version, content: $this->content),
            'plain' => $version, // For plain text, just use the version string directly
            default => throw new RuntimeException(message: "Unsupported mode: {$this->mode}. Please use 'json', 'xml', or 'plain'."),
        };

        // Write content back to file
        file_put_contents(filename: config('bump-version.file_path'), data: $content);
    }
}
