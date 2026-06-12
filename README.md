## Bump Version for Laravel projects

[![Tests](https://github.com/derian-cordoba/laravel-bump-version/actions/workflows/tests.yml/badge.svg)](https://github.com/derian-cordoba/laravel-bump-version/actions)
[![Latest Version](https://img.shields.io/github/v/release/derian-cordoba/laravel-bump-version?label=version)](https://github.com/derian-cordoba/laravel-bump-version/releases)
[![License](https://img.shields.io/github/license/derian-cordoba/laravel-bump-version)](LICENSE)

**Laravel Bump Version** is a lightweight library to handle semantic version bumping (`major.minor.patch`) in Laravel projects.

## Installation

Install it via Composer:

```bash
composer require derian-cordoba/laravel-bump-version
```

## Integration

### Register the Service Provider

Add the service provider in your `bootstrap/providers.php` (after Laravel 11.x) if you are not using package auto-discovery:

```php
<?php

return [
    App\Providers\AppServiceProvider::class,
    BumpVersion\Providers\ServiceProvider::class, // Add this line
];
```

If you are using Laravel 10.x or earlier, add it to your `config/app.php`:

```php
'providers' => [
    BumpVersion\Providers\ServiceProvider::class, // Add this line
],
```

### Register the Facade (Optional)

To use a short alias like `BumpVersion::major()`:

```php
'aliases' => [
    'BumpVersion' => BumpVersion\Facades\BumpVersion::class,
],
```

Then you can do:

```php
<?php

use BumpVersion\Facades\BumpVersion;

BumpVersion::major(); // Bumps the major version
```

### Publish the Config (Optional)

You can publish the default config to customize the version file path:

```bash
php artisan vendor:publish --provider="BumpVersion\Providers\ServiceProvider"
```

## Quick Usage

Basic PHP usage:

```php
<?php

use BumpVersion\VersionHandler;

$handler = app(VersionHandler::class);

// Bump patch: 1.0.0 → 1.0.1
$handler->patch();

// Bump minor: 1.0.0 → 1.1.0
$handler->minor();

// Bump major: 1.0.0 → 2.0.0
$handler->major();

// Get current version
$currentVersion = $handler->currentVersion(); // e.g., "1.0.0"
```

Also, you can use the verbose mode to bump the version:

```php
<?php

use BumpVersion\Enums\BumpType;
use BumpVersion\VersionHandler;

$handler = app(VersionHandler::class);

// Bump major: 1.0.0 → 2.0.0
$handler->bump(BumpType::MAJOR);
```

Using the facade:

```php
use BumpVersion\Facades\BumpVersion;

BumpVersion::major(); // Bumps the major version
BumpVersion::minor(); // Bumps the minor version
BumpVersion::patch(); // Bumps the patch version

$currentVersion = BumpVersion::currentVersion(); // e.g., "1.0.0"
```

To get the current version globally, you can use the `version()` or `currentVersion()` method:

```php
<?php

$currentVersion = version(); // e.g., "1.0.0"
$currentVersion = currentVersion(); // e.g., "1.0.0"
```

## Configuration

The default config (`config/bump-version.php`) looks like this:

```php
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
     * You can change this to 'json', 'plain', 'xml', or any custom mode you implement.
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

    /**
     * Default version number to use if the file does not exist or is empty.
     */
    'default_version' => env('BUMP_VERSION_DEFAULT', '0.0.0'),

    /**
     * Available formatters to read and write version files.
     */
    'formatters' => [
        'readers' => [],
        'writers' => [],
    ],
];
```

### Custom Readers And Writers

You can add a custom mode by registering formatter classes in the config. Readers receive the raw file content and return the version string. Writers receive the new version and the current file content, then return the full content that should be written back.

```php
'mode' => 'dotenv',

'formatters' => [
    'readers' => [
        'dotenv' => App\Support\Version\DotenvReader::class,
    ],
    'writers' => [
        'dotenv' => App\Support\Version\DotenvWriter::class,
    ],
],
```

```php
final class DotenvReader
{
    public static function read(string $content): ?string
    {
        preg_match('/^APP_VERSION=(.+)$/m', $content, $matches);

        return $matches[1] ?? null;
    }
}

final class DotenvWriter
{
    public static function write(string $version, string $content): string
    {
        return preg_replace('/^APP_VERSION=.+$/m', "APP_VERSION={$version}", $content)
            ?? $content;
    }
}
```

## Testing

Run the tests using PHPUnit:

```bash
composer install
composer test -- --testdox
```

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Contributing

Feel free to submit issues or pull requests. Contributions and suggestions are welcome!
