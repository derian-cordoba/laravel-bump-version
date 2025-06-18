<?php

namespace BumpVersion\Console\Commands;

use BumpVersion\Enums\BumpType;

final class BumpPatchCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bump:patch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bump patch version (e.g. 1.2.0 => 1.2.1)';

    /**
     * {@inheritDoc}
     */
    public function bumpType(): BumpType
    {
        return BumpType::PATCH;
    }
}