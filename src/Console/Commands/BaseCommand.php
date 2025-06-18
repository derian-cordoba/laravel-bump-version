<?php

namespace BumpVersion\Console\Commands;

use BumpVersion\Contracts\HandlerContract;
use BumpVersion\Enums\BumpType;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    public function __construct(private readonly HandlerContract $handler)
    {
        parent::__construct();
    }

    /**
     * Return the bump type for using in bumping time.
     */
    abstract public function bumpType(): BumpType;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $bumpType = $this->bumpType();
        $previousVersion = $this->handler->currentVersion();

        $this->handler->bump(bumpType: $bumpType);

        $newVersion = $this->handler->currentVersion();

        $this->info(string: "🔔 Bump version from $previousVersion to $newVersion using {$bumpType->value}");
    }
}