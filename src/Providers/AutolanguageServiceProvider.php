<?php

namespace Deisss\Autolanguage\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the package.
 *
 * Class AutolanguageServiceProvider
 * @package Deisss\Autolanguage\Providers
 */
class AutolanguageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * --------------------------------
         *   CONFIGURATION
         * --------------------------------
         */
        $DS = DIRECTORY_SEPARATOR;

        // Where to locate the base of this plugin
        $root = __DIR__.$DS.'..'.$DS;

        $this->loadMigrationsFrom($root.'Migrations');

        // Publishing configuration file
        $this->publishes(
            array(
                $root.'Config'.$DS.'autolanguage.php' => config_path('autolanguage.php')
            ),
            'config'
        );

        $this->app->make('Deisss\Autolanguage\Http\Controllers\LanguageController');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
