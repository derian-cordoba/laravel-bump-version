<?php

namespace BumpVersion\Facades;

use BumpVersion\VersionHandler;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void bump(\BumpVersion\Enums\BumpType $bumpType)
 * @method static string currentVersion()
 * 
 * @see \BumpVersion\BumpVersion
 */
final class BumpVersion extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return VersionHandler::class;
    }
}
