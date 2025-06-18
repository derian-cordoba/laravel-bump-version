<?php

namespace Tests\Payloads;

use BumpVersion\Enums\BumpType;

final class VersionBumpCase
{
    public function __construct(public readonly string $initialVersion,
                                public readonly BumpType $bumpType,
                                public readonly string $expectedVersion)
    {
        //
    }

    /**
     * Get the identifier for the version bump case.
     *
     * This identifier is a combination of the bump type and the initial version,
     * which can be useful for distinguishing between different test cases.
     */
    public function identifier(): string
    {
        return "{$this->bumpType->value}_{$this->initialVersion}";
    }
}
