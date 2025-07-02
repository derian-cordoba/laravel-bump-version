<?php

return [
    /**
     * File path where the version number will be stored.
     * 
     * This file should contain a single line with the version number.
     * 
     * By default, it is set to 'version' in the base path of the application.
     */
    'file_path' => env('BUMP_VERSION_FILE_PATH', base_path('composer.json')),

    /**
     * Mode configuration for reading the version number.
     * 
     * This allows you to specify how the version number should be read.
     * 
     * By default, it is set to read from a JSON file.
     * 
     * You can change this to 'json', 'plain', or any other custom mode you implement.
     */
    'mode' => env('BUMP_VERSION_MODE', 'json'),

    /**
     * Key used to access the version number in the file.
     * 
     * This is particularly useful when using JSON or XML files where the version number is stored under a specific key.
     * 
     * By default, it is set to 'version'.
     */
    'version_key' => env('BUMP_VERSION_KEY', 'version'),
];
