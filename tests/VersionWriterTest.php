<?php

namespace Tests;

use BumpVersion\Tools\VersionWriter;
use BumpVersion\Tools\XMLReader;
use Orchestra\Testbench\TestCase;
use RuntimeException;
use stdClass;
use Tests\Payloads\CustomWriter;

final class VersionWriterTest extends TestCase
{
    public function test_writes_plain_version(): void
    {
        // Given
        $filePath = 'plain-writer.version';

        config()->set(key: 'bump-version.mode', value: 'plain');
        config()->set(key: 'bump-version.file_path', value: $filePath);

        file_put_contents(filename: $filePath, data: '1.0.0');

        // When
        (new VersionWriter())->write(version: '2.0.0');

        // Then
        $this->assertSame(expected: '2.0.0',
                          actual: file_get_contents(filename: $filePath));

        // cleanup
        unlink(filename: $filePath);
    }

    public function test_writes_json_version(): void
    {
        // Given
        $filePath = 'json-writer.json';

        config()->set(key: 'bump-version.mode', value: 'json');
        config()->set(key: 'bump-version.file_path', value: $filePath);
        config()->set(key: 'bump-version.version_key', value: 'version');

        file_put_contents(filename: $filePath,
                          data: json_encode(value: ['name' => 'my-package', 'version' => '1.0.0'],
                                            flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // When
        (new VersionWriter())->write(version: '2.0.0');

        // Then
        $result = json_decode(json: file_get_contents(filename: $filePath), associative: true);

        $this->assertSame(expected: '2.0.0', actual: $result['version']);
        $this->assertSame(expected: 'my-package', actual: $result['name']);

        // cleanup
        unlink(filename: $filePath);
    }

    public function test_writes_xml_version(): void
    {
        // Given
        $filePath = 'xml-writer.xml';

        config()->set(key: 'bump-version.mode', value: 'xml');
        config()->set(key: 'bump-version.file_path', value: $filePath);
        config()->set(key: 'bump-version.version_key', value: 'version');

        file_put_contents(filename: $filePath, data: <<<XML
            <?xml version="1.0"?>
            <root>
                <version>1.0.0</version>
            </root>
            XML);

        // When
        (new VersionWriter())->write(version: '2.0.0');

        // Then
        $writtenContent = file_get_contents(filename: $filePath);

        $this->assertSame(expected: '2.0.0',
                          actual: XMLReader::read(content: $writtenContent));

        // cleanup
        unlink(filename: $filePath);
    }

    public function test_writes_json_deep_version(): void
    {
        // Given
        $filePath = 'json-deep-writer.json';

        config()->set(key: 'bump-version.mode', value: 'json');
        config()->set(key: 'bump-version.file_path', value: $filePath);
        config()->set(key: 'bump-version.version_key', value: 'deep.key.version');

        file_put_contents(filename: $filePath,
                          data: json_encode(value: ['deep' => ['key' => ['version' => '1.0.0']]],
                                            flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // When
        (new VersionWriter())->write(version: '2.0.0');

        // Then
        $result = json_decode(json: file_get_contents(filename: $filePath), associative: true);

        $this->assertSame(expected: '2.0.0', actual: data_get(target: $result, key: 'deep.key.version'));

        // cleanup
        unlink(filename: $filePath);
    }

    public function test_writes_xml_deep_version(): void
    {
        // Given
        $filePath = 'xml-deep-writer.xml';

        config()->set(key: 'bump-version.mode', value: 'xml');
        config()->set(key: 'bump-version.file_path', value: $filePath);
        config()->set(key: 'bump-version.version_key', value: 'deep.key.version');

        file_put_contents(filename: $filePath, data: <<<XML
            <?xml version="1.0"?>
            <root>
                <deep>
                    <key>
                        <version>1.0.0</version>
                    </key>
                </deep>
            </root>
            XML);

        // When
        (new VersionWriter())->write(version: '2.0.0');

        // Then
        $writtenContent = file_get_contents(filename: $filePath);

        $this->assertSame(expected: '2.0.0',
                          actual: XMLReader::read(content: $writtenContent));

        // cleanup
        unlink(filename: $filePath);
    }

    public function test_throws_for_unsupported_mode(): void
    {
        config()->set(key: 'bump-version.mode', value: 'unsupported');
        config()->set(key: 'bump-version.file_path', value: 'non-existent-for-test.txt');

        $this->expectException(exception: RuntimeException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/Unsupported mode/');

        (new VersionWriter())->write(version: '1.0.0');
    }

    public function test_throws_when_writer_has_no_write_method(): void
    {
        config()->set(key: 'bump-version.mode', value: 'custom');
        config()->set(key: 'bump-version.file_path', value: 'non-existent-for-test.txt');
        config()->set(key: 'bump-version.formatters.writers.custom', value: stdClass::class);

        $this->expectException(exception: RuntimeException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/must define a static write method/');

        (new VersionWriter())->write(version: '1.0.0');
    }

    public function test_writes_version_using_custom_writer(): void
    {
        // Given
        $filePath = 'custom-writer.version';

        config()->set(key: 'bump-version.mode', value: 'custom');
        config()->set(key: 'bump-version.file_path', value: $filePath);
        config()->set(key: 'bump-version.formatters.writers.custom', value: CustomWriter::class);

        file_put_contents(filename: $filePath, data: 'version=1.0.0');

        // When
        (new VersionWriter())->write(version: '2.0.0');

        // Then
        $this->assertSame(expected: 'version=2.0.0',
                          actual: file_get_contents(filename: $filePath));

        // cleanup
        unlink(filename: $filePath);
    }
}
