<?php

namespace Yadahan\AuthenticationLog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;

class AuthenticationLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'authentication-log');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'authentication-log');

        $this->mergeConfigFrom(__DIR__.'/../config/authentication-log.php', 'authentication-log');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'authentication-log-migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/authentication-log'),
            ], 'authentication-log-views');

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/authentication-log'),
            ], 'authentication-log-translations');

            $this->publishes([
                __DIR__.'/../config/authentication-log.php' => config_path('authentication-log.php'),
            ], 'authentication-log-config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\ClearCommand::class,
            ]);
        }
    }
}
