<?php

namespace BumpVersion\Contracts;

use BumpVersion\Enums\BumpType;

interface HandlerContract
{
     /**
     * Bump the current version to the next version.
     * 
     * @param BumpType $bumpType The type of version bump to apply (MAJOR, MINOR, PATCH).
     */
    public function bump(BumpType $bumpType): void;

    /**
     * Get the current version.
     * 
     * @return string The current version in semantic versioning format (e.g., "1.0.0").
     */
    public function currentVersion(): string;
}
