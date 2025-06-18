<?php

namespace BumpVersion\Providers;

use BumpVersion\Console\Commands\BumpMajorCommand;
use BumpVersion\Console\Commands\BumpMinorCommand;
use BumpVersion\Console\Commands\BumpPatchCommand;
use BumpVersion\Contracts\HandlerContract;
use BumpVersion\Contracts\ReaderContract;
use BumpVersion\Contracts\WriterContract;
use BumpVersion\Tools\VersionReader;
use BumpVersion\Tools\VersionWriter;
use BumpVersion\VersionHandler;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    private const CONFIG_PATH = __DIR__ . '/../../config/bump-version.php';

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            path: static::CONFIG_PATH,
            key: 'bump-version',
        );
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes(
            paths: [static::CONFIG_PATH => $this->getConfigPath()],
            groups: 'config',
        );

        $this->app->bind(
            abstract: HandlerContract::class,
            concrete: VersionHandler::class,
        );

        $this->app->bind(
            abstract: ReaderContract::class,
            concrete: VersionReader::class,
        );

        $this->app->bind(
            abstract: WriterContract::class,
            concrete: VersionWriter::class,
        );

        if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    BumpMajorCommand::class,
                    BumpMinorCommand::class,
                    BumpPatchCommand::class,
                ]
            );
        }
    }

    /**
     * Publish the config file
     *
     * @param  string $configPath
     */
    protected function publishConfig(string $configPath): void
    {
        $this->publishes(
            paths: [$configPath => config_path('bump-version.php')],
            groups: 'config',
        );
    }

    /**
     * Get the config path
     */
    protected function getConfigPath(): string
    {
        return config_path('bump-version.php');
    }
}
