<?php

/*
|--------------------------------------------------------------------------
| Autolanguage configuration
|--------------------------------------------------------------------------
|
| You can configure here how the language system is defined.
|
*/

return [
    /*
     * Multiple language supported, this automatically translate many languages strings
     * into a single one usable by the translate engine of Laravel.
     */
    'languages' => [
        // French
        'fr' => ['fr', 'fr_fr', 'fr-fr', 'fr-FR', 'fr_FR'],

        // English
        'en' => ['en', 'en-gb', 'en_gb', 'en-GB', 'en_GB',
                       'en-us', 'en_us', 'en-US', 'en_US',
                       'en-ca', 'en_ca', 'en-CA', 'en_CA'
        ],

        // German
        'de' => ['de', 'de-de', 'de_de', 'de-DE', 'de_DE'],

        // Spanish
        'es' => ['es', 'es-es', 'es_es', 'es-ES', 'es_ES']
    ],

    /*
     * Used by migration to properly configure installation scripts.
     */
    'migrations' => [
        // The 'users' table (null for "auto detection")
        'table' => 'users'
    ]
];