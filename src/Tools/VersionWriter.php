<?php

namespace BumpVersion\Tools;

use BumpVersion\Contracts\WriterContract;
use Illuminate\Support\Arr;
use RuntimeException;

use function array_key_exists;
use function is_callable;

class VersionWriter implements WriterContract
{
    private readonly ?string $mode;
    private readonly ?string $content;

    public function __construct(?string $mode = null,
                                ?string $content = null)
    {
        $this->mode = $mode;
        $this->content = $content;
    }

    /**
     * @return array<string, class-string>
     */
    private function availableWriters(): array
    {
        return array_merge([
            'json' => JSONWriter::class,
            'plain' => PlainWriter::class,
            'xml' => XMLWriter::class,
        ], (array) config(key: 'bump-version.formatters.writers', default: []));
    }

    /**
     * {@inheritDoc}
     */
    public function write(string $version): void
    {
        $mode = $this->mode ?? config(key: 'bump-version.mode', default: 'json');
        $content = $this->content ?? FileContent::read();
        $availableWriters = $this->availableWriters();

        if (! array_key_exists(key: $mode, array: $availableWriters)) {
            $formattedAvailableWriters = Arr::join(array: array_keys(array: $availableWriters),
                                                   glue: ', ',
                                                   finalGlue: ' or ');

            throw new RuntimeException(message: "Unsupported mode: '$mode'. Please use $formattedAvailableWriters.");
        }

        $writer = $availableWriters[$mode];

        if (! is_callable(value: [$writer, 'write'])) {
            throw new RuntimeException(message: "Writer '{$writer}' must define a static write method.");
        }

        $filePath = config(key: 'bump-version.file_path');

        $bytes = file_put_contents(filename: $filePath,
                                   data: $writer::write(version: $version, content: $content));

        if ($bytes === false) {
            throw new RuntimeException(message: "Failed to write version to file: '$filePath'.");
        }
    }
}
