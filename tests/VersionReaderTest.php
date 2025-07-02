<?php

namespace Tests;

use BumpVersion\Tools\VersionReader;
use Orchestra\Testbench\TestCase;
use Tests\Concerns\ProvidesVersionReaderCases;
use Tests\Payloads\VersionReaderCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class VersionReaderTest extends TestCase
{
    use ProvidesVersionReaderCases;

    #[DataProvider(methodName: 'versionReaderProvider')]
    public function test_reads_version_correctly(VersionReaderCase $case): void
    {
        // Given
        $reader = new VersionReader();

        // When
        config()->set(key: 'bump-version.mode', value: $case->mode);
        config()->set(key: 'bump-version.file_path', value: $case->filePath);

        if ($case->versionKey !== null) {
            config()->set(key: 'bump-version.version_key', value: $case->versionKey);
        }

        file_put_contents(filename: $case->filePath, data: $case->fileContent);

        // Then
        $this->assertEquals(expected: $case->expectedVersion, actual: $reader->read());
        $this->assertFileExists(filename: $case->filePath);

        // cleanup
        unlink(filename: $case->filePath);
    }
}