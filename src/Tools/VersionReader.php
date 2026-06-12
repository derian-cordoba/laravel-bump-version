<?php

namespace BumpVersion\Tools;

use BumpVersion\Contracts\ReaderContract;
use RuntimeException;

use function array_key_exists;
use function is_callable;

class VersionReader implements ReaderContract
{
    /**
     * {@inheritDoc}
     */
    public function read(): string
    {
        // Configure the mode for reading the version number based on the configuration.
        $mode = config(key: 'bump-version.mode', default: 'json');

        $availableReaders = $this->availableReaders();

        if (! array_key_exists(key: $mode, array: $availableReaders)) {
            $formattedAvailableReaders = implode(separator: ', ', array: array_keys(array: $availableReaders));

            throw new RuntimeException(message: "Unsupported mode: '$mode'. Please use $formattedAvailableReaders.");
        }

        $reader = $availableReaders[$mode];

        if (! is_callable(value: [$reader, 'read'])) {
            throw new RuntimeException(message: "Reader '$reader' must define a static read method.");
        }

        $fileContent = FileContent::read();

        $version = $reader::read(content: $fileContent);

        // Keep the raw file content as a fallback when a formatter cannot resolve a version.
        return $version ?? $fileContent;
    }

    /**
     * @return array<string, class-string>
     */
    private function availableReaders(): array
    {
        return [
            'json' => JSONReader::class,
            'plain' => PlainReader::class,
            'xml' => XMLReader::class,
            ...config()->array(key: 'bump-version.formatters.readers', default: []),
        ];
    }
}
