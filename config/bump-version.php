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
];
