<?php

if (! function_exists('version')) {
    /**
     * Return the current version
     *
     * @return string The current version
     */
    function version(): string
    {
        return app(abstract: \BumpVersion\VersionHandler::class)->currentVersion();
    }
}

if (! function_exists('currentVersion')) {
    /**
     * Return the current version
     *
     * @return string The current version
     */
    function currentVersion(): string
    {
        return app(abstract: \BumpVersion\VersionHandler::class)->currentVersion();
    }
}
