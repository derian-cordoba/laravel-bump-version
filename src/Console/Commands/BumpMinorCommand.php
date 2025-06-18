<?php

namespace BumpVersion\Console\Commands;

use BumpVersion\Enums\BumpType;

final class BumpMinorCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bump:minor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bump minor version (e.g. 1.2.0 => 1.3.0)';

    /**
     * {@inheritDoc}
     */
    public function bumpType(): BumpType
    {
        return BumpType::MINOR;
    }
}