# Simple theme support for Laravel 4

Inspired by [lightgear/theme](https://github.com/lightgear/theme), but not depend on specific asset manager.

## Install

Composer require:

    "bigecko/laravel-theme": "dev-master"

Service provider:

    'Bigecko\LaravelTheme\LaravelThemeServiceProvider',

Alias:

    'Theme' => 'Bigecko\LaravelTheme\Facade',

## Usage

### Structure

```
├── public/
    └── themes/
        ├── mytheme/
        |   ├── js/
        |   ├── css/
        |   └── views/
        |
        └── anothertheme/

```

Create a new folder `public/themes`.

Create a folder in `themes` use your theme name, like `mytheme`.

Put your theme templates file to `mytheme/views`.

### init theme

```php
Theme::init('mytheme');
```

### custom path

```php
Theme::init('mytheme', array(
    'public_dirname' => 'allthemes',    // Base dirname for contain all themes, relative to public path.
    'views_path' => app_path('views'),  // Change the path to contain theme templates.
));
```

Once you change the views_path, the sub dir `views` for theme is not needed,  
just create your theme folder in views_path, and put templates in it.  
like: `app/views/mytheme/hello.blade.php`.


### Code example

```php

View::make('home');  // First find in 'public/themes/mytheme/views/'.
                     // If file not exist, will use default location 'app/views/'.


Theme::asset('js/a.js');  // 'http://domain/themes/mytheme/js/a.js'

Theme::publicPath('js/jquery.js')  // /path/to/project/public/themes/mytheme/js/jquery.js

Theme::name(); // Get current theme name.

```

Also support package templates overriding, just put package templates to your theme views folder.


## Why use this?

Simple:

  * Dot not need change code to render template, still `View::make`.
  * No asset management or other dependencies.
  * No new config file.
  * Just few lines of code, easy to read.
  * Only for theme, no more other responsibilities.

## TODO

  * Add unit testing.
