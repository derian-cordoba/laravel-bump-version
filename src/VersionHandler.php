<?php

namespace BumpVersion;

use BumpVersion\Contracts\HandlerContract;
use BumpVersion\Contracts\ReaderContract;
use BumpVersion\Contracts\WriterContract;
use BumpVersion\Enums\BumpType;
use BumpVersion\Tools\VersionBuilder;

class VersionHandler implements HandlerContract
{
    public function __construct(private readonly WriterContract $writer,
                                private readonly ReaderContract $reader)
    {
        //
    }

    /**
     * Bump version using major type
     */
    public function major(): void
    {
        $this->bump(bumpType: BumpType::MAJOR);
    }

    /**
     * Bump version using minor type
     */
    public function minor(): void
    {
        $this->bump(bumpType: BumpType::MINOR);
    }

    /**
     * Bump version using patch type
     */
    public function patch(): void
    {
        $this->bump(bumpType: BumpType::PATCH);
    }

    /**
     * {@inheritDoc}
     */
    public function bump(BumpType $bumpType): void
    {
        $builder = new VersionBuilder(currentVersion: $this->currentVersion(),
                                      bumpType: $bumpType);

        $this->writer->write(version: $builder->bump());
    }

    /**
     * {@inheritDoc}
     */
    public function currentVersion(): string
    {
        return $this->reader->read();
    }
}
