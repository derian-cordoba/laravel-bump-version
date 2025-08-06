<?php

namespace Tests\Concerns;

use Tests\Payloads\VersionReaderCase;

trait ProvidesVersionReaderCases
{
    public static function versionReaderProvider(): array
    {
        return [
            'plain_mode' => [
                new VersionReaderCase(mode: 'plain',
                                      filePath: 'version_plain',
                                      fileContent: '1.2.3',
                                      expectedVersion: '1.2.3'),
            ],
            'json_mode' => [
                new VersionReaderCase(mode: 'json',
                                      filePath: 'composer-test.json',
                                      fileContent: json_encode(['version' => '2.3.4']),
                                      expectedVersion: '2.3.4',
                                      versionKey: 'version'),
            ],
            'json_deep_mode' => [
                new VersionReaderCase(mode: 'json',
                                      filePath: 'composer-deep.json',
                                      fileContent: json_encode(['deep' => ['key' => ['version' => '5.3.3']]]),
                                      expectedVersion: '5.3.3',
                                      versionKey: 'deep.key.version'),
            ],
            'xml_mode' => [
                new VersionReaderCase(mode: 'xml',
                                      filePath: 'xml-test.xml',
                                      fileContent: <<<XML
                                        <?xml version="1.0"?>
                                        <root>
                                            <version>3.4.5</version>
                                        </root>
                                      XML,
                                      expectedVersion: '3.4.5',
                                      versionKey: 'version'),
            ],
            'xml_deep_mode' => [
                new VersionReaderCase(mode: 'xml',
                                      filePath: 'xml-deep.xml',
                                      fileContent: <<<XML
                                        <?xml version="1.0"?>
                                        <root>
                                            <deep>
                                                <key>
                                                    <version>6.7.8</version>
                                                </key>
                                            </deep>
                                        </root>
                                      XML,
                                      expectedVersion: '6.7.8',
                                      versionKey: 'deep.key.version'),
            ],
        ];
    }
}
