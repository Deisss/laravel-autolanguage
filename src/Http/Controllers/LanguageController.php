<?php

namespace Deisss\Autolanguage\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Response;
use Validator;
use Illuminate\Support\Facades\Auth;
use Deisss\Autolanguage\Http\Middleware\Language;

/**
 * Class LanguageController
 * @package Deisss\Autolanguage\Controllers
 */
class LanguageController extends Controller
{
    /**
     * Apply given language to system.
     *
     * @param string $potentialLanguage The potential language (the one submitted)
     * @return null|string The language found, or null if not
     */
    protected function applyLanguage($potentialLanguage)
    {
        $middlewareLanguage = new Language();
        $selectedLanguage = null;

        if ($middlewareLanguage->isSupportedLanguage($potentialLanguage)) {
            $selectedLanguage = $middlewareLanguage->getSupportedLanguage($potentialLanguage);
        }

        if ($selectedLanguage) {
            $user = Auth::user();
            if (!empty($user)) {
                $user->language = $selectedLanguage;
                $user->save();
            }

            session('language', $selectedLanguage);
            return $selectedLanguage;
        } else {
            return null;
        }
    }

    /**
     * Change the language currently in use inside the application
     *
     * @param Request $request
     * @return Response The response
     */
    public function language(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'language' => 'required|string|max:8',
        ));

        // Check request validation
        if ($validator->fails()) {
            return response(json_encode(array(
                'validation' => $validator->errors()
            )), 422)->header('Content-Type', 'application/json');
        }

        $selectedLanguage = $this->applyLanguage($request->input('language'));

        if ($selectedLanguage) {
            return response(json_encode(array(
                'language' => $selectedLanguage
            )))->cookie(
                'language', $selectedLanguage
            );
        } else {
            abort(422);
        }
    }
}