<?php

namespace BumpVersion\Facades;

use BumpVersion\VersionHandler;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void bump(\BumpVersion\Enums\BumpType $bumpType)
 * @method static void major()
 * @method static void minor()
 * @method static void patch()
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
