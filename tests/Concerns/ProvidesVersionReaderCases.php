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
        ];
    }
}
