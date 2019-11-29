<?php
namespace faraamds\fias\Providers;

use faraamds\fias\Classes\Fias;
use faraamds\fias\Console\Commands\FiasImport;
use faraamds\fias\Console\Commands\FiasUpdate;
use faraamds\fias\database\ProcedureLoader;
use Illuminate\Support\ServiceProvider;
use faraamds\fias\Console\Commands\MakeMigrations;

/**
 * Fias service provider
 *
 * @package faraamds\fias
 */
class FiasServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('fias.fias', function () {
            return new Fias();
        });

        // Here we register commands for artisan
        $this->app->singleton('command.make-migrations', function ($app) {
            return $app->make(MakeMigrations::class);
        });
        $this->app->singleton('command.load-procedures', function ($app) {
            return $app->make(ProcedureLoader::class);
        });
        $this->app->singleton('command.import', function ($app) {
            return $app->make(FiasImport::class);
        });
        $this->app->singleton('command.update', function ($app) {
            return $app->make(FiasUpdate::class);
        });

        $this->commands(['command.make-migrations', 'command.import', 'command.update', 'command.load-procedures']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}
