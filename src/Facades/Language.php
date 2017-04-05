<?php

namespace Deisss\Autolanguage\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Routing\Router
 */
class Language extends Facade
{
    /*
    * Register the typical authentication routes for an application.
    *
    * @return void
    */
    public static function routes()
    {
        $router = static::$app->make('router');
        $router->post('language', '\Deisss\Autolanguage\Http\Controllers\LanguageController@language')
            ->name('language');
    }
}
