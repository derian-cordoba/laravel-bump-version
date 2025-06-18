<?php

namespace Tests;

use BumpVersion\Contracts\ReaderContract;
use BumpVersion\Contracts\WriterContract;
use BumpVersion\VersionHandler;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Concerns\ProvidesVersionBumpCases;
use Tests\Payloads\VersionBumpCase;

final class VersionHandlerTest extends TestCase
{
    use ProvidesVersionBumpCases;

    #[DataProvider(methodName: 'versionProvider')]
    public function test_it_bumps_the_version_correctly(VersionBumpCase $case): void
    {
        $reader = $this->createMock(ReaderContract::class);
        $reader->expects($this->once())
            ->method('read')
            ->willReturn($case->initialVersion);

        $writer = $this->createMock(WriterContract::class);
        $writer->expects($this->once())
            ->method('write')
            ->with($case->expectedVersion);

        $handler = new VersionHandler(writer: $writer, reader: $reader);

        $handler->bump(bumpType: $case->bumpType);
    }
}
