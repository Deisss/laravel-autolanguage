<?php

namespace Deisss\Autolanguage\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

/**
 * Class Language
 * @package App\Http\Middleware
 *
 * This class helps to define the language, and automatically switch to the language if available in our
 * list of supported languages.
 */
class Language
{
    /**
     * Check if the given language is part of the supported language list or not.
     *
     * @param $language string The language to test
     * @return bool True if itùs supported, false otherwise
     */
    public function isSupportedLanguage($language)
    {
        $supportedLanguages = \Config::get('autolanguage.languages', null);

        // Everything is valid if nothing is configured.
        if (empty($supportedLanguages) || !is_array($supportedLanguages)) {
            return true;
        }

        foreach ($supportedLanguages as $key => $value) {
            if (!empty($value) && is_array($value) && in_array($language, $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a language. If any problem, fallback to the default one.
     *
     * @param $language string Get a language.
     * @return string The supported language
     */
    public function getSupportedLanguage($language)
    {
        $supportedLanguages = \Config::get('autolanguage.languages', null);

        // Everything is valid if nothing is configured.
        if (empty($supportedLanguages) || !is_array($supportedLanguages)) {
            return $language;
        }

        foreach ($supportedLanguages as $key => $value) {
            if (!empty($value) && is_array($value) && in_array($language, $value)) {
                return $key;
            }
        }

        return \Config::get('app.fallback_locale');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // The user exists, no need to do anything
        if (!empty($request->user()) && !empty($request->user()->language)) {
            \App::setLocale($request->user()->language);
            return $next($request);

        // The session language exists, no need to do anything
        } elseif ($request->session()->has('language')) {
            \App::setLocale($request->session()->get('language'));
            return $next($request);

        // The cookie exist, no need either to do anything
        } elseif (!empty($request->cookie('language'))) {
            \App::setLocale($request->cookie('language'));
            return $next($request);

        // Nothing, we have to set cookies, and, therefor, detect cookies...
        } else {
            // The browser languages any browsers gives by default.
            $browserLanguages = $request->getLanguages() ?: array();
            $selectedLanguage = null;

            // We stop -if possible- to the first language supported by browser
            foreach($browserLanguages as $potentialLanguage) {
                if ($this->isSupportedLanguage($potentialLanguage)) {
                    $selectedLanguage = $this->getSupportedLanguage($potentialLanguage);
                    break;
                }
            }

            if (!empty($selectedLanguage)) {
                session('language', $selectedLanguage);
                //$request->session()->set('language', $selectedLanguage);
                \App::setLocale($selectedLanguage);
            }
            return $next($request);
        }
    }
}
