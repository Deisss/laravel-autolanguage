# Autolanguage

## Introduction

/!\ NOT PRODUCTION READY - STILL UNDER DEVELOPMENT/TESTS /!\

Add the language support layer into laravel, supporting: cookie, session, user
auth and browser detection.


## Installation

Run the following command from the root folder of your Laravel project:
```bash
composer require deisss/autolanguage
```

Once installed, edit the file ```config/app.php``` to add the following provider
and aliases:

```php
<?php
  
    // (...)
  
    'providers' => [
        
        // (...)
        
        Deisss\Autolanguage\Providers\AutolanguageServiceProvider::class,
    ],
    
    // (...)
    
    'aliases' => [
        
        // (...)
        
        Deisss\Autolanguage\Facades\Language::class,
    ]
]
```

We have done most of it, we still need to "automate" this, the system is able to
choose the right language even without any input from the user (using browser info).  
A middleware exists for this, in the file ```app/Http/Kernel.php```, add:

```php
<?php

class Kernel extends HttpKernel
{
    
    // (...)
    
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            
            // (...)
            
            \Deisss\Autolanguage\Http\Middleware\Language::class,
        ]
    ];
    
    // (...)
}
```



## Routes

This package expose a route ```POST``` / ```language``` to update the language
on a logged and/or unlogged user, you can add it easily in the ```routes/web.php```:

```php
<?php
  
// (...)
  
Language::routes();
```


## Configuration

There is few configuration you can do, about the migration and the allowed language:

```bash
php artisan vendor:publish
```

Especially if you want to add more supported language you NEED to do this.

Will add a file ```autolanguage.php``` in ```config``` folder, which you can tweak,
for example adding new languages and how the migration catch the ```users``` table.

Don't forget also to change the default fallback language in ```config/app.php``` to
the one you want by default if nothing is available:
```php
<?php
  
// (...)
    
return [
    
    // (...)
    
    'fallback_locale' => 'en',
    
    // (...)
    
];
```

## Getting the current language

You probably don't need this as the language is automatically set for you (and
therefore the system will apply the right translation for you, if, of course
the folder in ```resources/lang/{language}``` is correctly filled):
```php
<?php
  
// (...)
  
$language = \App::getLocale();
```

Will give you the currently used language for that user (and therefore the folder
used in ```resources/lang``` to translate the view).


## License

See LICENSE.MD file.
