<?php

namespace Tests\Payloads;

final class VersionReaderCase
{
    public function __construct(public readonly string $mode,
                                public readonly string $filePath,
                                public readonly string $fileContent,
                                public readonly string $expectedVersion,
                                public readonly ?string $versionKey = null)
    {
        //
    }
}