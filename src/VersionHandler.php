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
