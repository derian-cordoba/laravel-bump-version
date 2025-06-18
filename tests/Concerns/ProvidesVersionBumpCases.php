<?php

namespace Tests\Concerns;

use BumpVersion\Enums\BumpType;
use Tests\Payloads\VersionBumpCase;

trait ProvidesVersionBumpCases
{
    /**
     * Provides version bump cases for testing.
     *
     * @return array<string, array<VersionBumpCase>>
     */
    public static function versionProvider(): array
    {
        return collect(value: static::versionCases())
            ->flatten()
            ->mapWithKeys(callback: static fn (VersionBumpCase $case): array => [$case->identifier() => [$case]])
            ->toArray();
    }

    /**
     * Returns an array of version bump cases.
     *
     * @return array<array<VersionBumpCase>>
     */
    private static function versionCases(): array
    {
        return [
            [
                new VersionBumpCase(initialVersion: '1.0.0', bumpType: BumpType::PATCH, expectedVersion: '1.0.1'),
                new VersionBumpCase(initialVersion: '2.3.4', bumpType: BumpType::PATCH, expectedVersion: '2.3.5'),
                new VersionBumpCase(initialVersion: '0.1.9', bumpType: BumpType::PATCH, expectedVersion: '0.1.10'),
                new VersionBumpCase(initialVersion: '0.0.1', bumpType: BumpType::PATCH, expectedVersion: '0.0.2'),
            ],
            [
                new VersionBumpCase(initialVersion: '1.0.0', bumpType: BumpType::MINOR, expectedVersion: '1.1.0'),
                new VersionBumpCase(initialVersion: '1.2.0', bumpType: BumpType::MINOR, expectedVersion: '1.3.0'),
                new VersionBumpCase(initialVersion: '2.3.4', bumpType: BumpType::MINOR, expectedVersion: '2.4.0'),
                new VersionBumpCase(initialVersion: '0.1.9', bumpType: BumpType::MINOR, expectedVersion: '0.2.0'),
            ],
            [
                new VersionBumpCase(initialVersion: '1.0.0', bumpType: BumpType::MAJOR, expectedVersion: '2.0.0'),
                new VersionBumpCase(initialVersion: '2.5.0', bumpType: BumpType::MAJOR, expectedVersion: '3.0.0'),
                new VersionBumpCase(initialVersion: '0.1.9', bumpType: BumpType::MAJOR, expectedVersion: '1.0.0'),
                new VersionBumpCase(initialVersion: '0.0.1', bumpType: BumpType::MAJOR, expectedVersion: '1.0.0'),
                new VersionBumpCase(initialVersion: '1.2.3', bumpType: BumpType::MAJOR, expectedVersion: '2.0.0'),
            ],
        ];
    }
}
