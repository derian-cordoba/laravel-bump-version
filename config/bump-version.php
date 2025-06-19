<?php

return [
    /**
     * File path where the version number will be stored.
     * 
     * This file should contain a single line with the version number.
     * 
     * By default, it is set to 'version' in the base path of the application.
     */
    'file_path' => env('BUMP_VERSION_FILE_PATH', base_path('version')),

    /**
     * Default version number to use if the version file does not exist.
     * 
     * This should be a valid semantic version string.
     * 
     * By default, it is set to '0.0.1'.
     */
    'default_version' => env('BUMP_VERSION_DEFAULT_VERSION', '0.0.1'),
];
