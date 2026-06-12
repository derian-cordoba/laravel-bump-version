<?php

namespace Tests;

use BumpVersion\Tools\FileContent;
use Orchestra\Testbench\TestCase;

final class FileContentTest extends TestCase
{
    public function test_returns_default_version_when_file_does_not_exist(): void
    {
        config()->set(key: 'bump-version.file_path', value: 'non-existent-file.version');
        config()->set(key: 'bump-version.default_version', value: '1.2.3');

        $this->assertSame(expected: '1.2.3', actual: FileContent::read());
    }

    public function test_reads_and_trims_file_content(): void
    {
        // Given
        $filePath = 'file-content-test.version';

        config()->set(key: 'bump-version.file_path', value: $filePath);

        file_put_contents(filename: $filePath, data: '  4.5.6  ');

        // Then
        $this->assertSame(expected: '4.5.6', actual: FileContent::read());

        // cleanup
        unlink(filename: $filePath);
    }
}
