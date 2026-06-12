<?php

namespace Tests;

use BumpVersion\Tools\VersionReader;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use RuntimeException;
use stdClass;
use Tests\Concerns\ProvidesVersionReaderCases;
use Tests\Payloads\CustomReader;
use Tests\Payloads\VersionReaderCase;

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

    public function test_reads_version_using_custom_reader(): void
    {
        // Given
        $filePath = 'custom-reader.version';
        $reader = new VersionReader();

        config()->set(key: 'bump-version.mode', value: 'custom');
        config()->set(key: 'bump-version.file_path', value: $filePath);
        config()->set(key: 'bump-version.formatters.readers.custom', value: CustomReader::class);

        file_put_contents(filename: $filePath, data: 'version=7.8.9');

        // Then
        $this->assertSame(expected: '7.8.9', actual: $reader->read());

        // cleanup
        unlink(filename: $filePath);
    }

    public function test_throws_for_unsupported_mode(): void
    {
        config()->set(key: 'bump-version.mode', value: 'unsupported');

        $this->expectException(exception: RuntimeException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/Unsupported mode/');

        (new VersionReader())->read();
    }

    public function test_throws_when_reader_has_no_read_method(): void
    {
        config()->set(key: 'bump-version.mode', value: 'custom');
        config()->set(key: 'bump-version.formatters.readers.custom', value: stdClass::class);

        $this->expectException(exception: RuntimeException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/must define a static read method/');

        (new VersionReader())->read();
    }
}
