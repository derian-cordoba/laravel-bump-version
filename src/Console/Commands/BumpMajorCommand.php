<?php

namespace BumpVersion\Console\Commands;

use BumpVersion\Enums\BumpType;

final class BumpMajorCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bump:major';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bump major version (e.g. 1.2.0 => 2.0.0)';

    /**
     * {@inheritDoc}
     */
    public function bumpType(): BumpType
    {
        return BumpType::MAJOR;
    }
}