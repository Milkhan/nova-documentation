# Help tool for Laravel Nova

<!-- [![Latest Version on Packagist](https://img.shields.io/packagist/v/dniccum/nova-documentation.svg?style=flat-square&color=#0E7FC0)](https://packagist.org/packages/dniccum/nova-documentation)
[![License](https://img.shields.io/packagist/l/dniccum/nova-documentation.svg?style=flat-square)](https://packagist.org/packages/dniccum/nova-documentation)
[![Total Downloads](https://img.shields.io/packagist/dt/dniccum/nova-documentation.svg?style=flat-square)](https://packagist.org/packages/dniccum/nova-documentation) -->

This is a tool for Laravel's Nova administrator panel that allows you to create markdown-based help for your application; without having to leave the Nova environment (based on dniccum/nova-documentation).
<!-- 
[![Screenshot](https://raw.githubusercontent.com/dniccum/nova-documentation/master/screenshots/screenshot-1.png)](https://raw.githubusercontent.com/dniccum/nova-documentation/master/screenshots/screenshot-1.png) -->

## Features

* Parses each markdown help and renders them in the Nova dashboard
* Dynamic page titles: Each h1 tag (`# title`) is set as the page title
    * Each page title is then used to construct a sidebar, allowing for navigation through your help.
    * Allows for nested directories
* Syntax highlighting for code blocks (via [highlight.js](https://highlightjs.org/))
* Replaces local links within the body content to work within the Nova environment.

## Installation

You can install the package via composer:

```
composer require dniccum/nova-help
```

You will then need to publish the package's configuration and blade view files to your applications installation:

```
php artisan vendor:publish --provider="Milkha\NovaHelp\ToolServiceProvider"
```

Finally, you will need to register the tool within the `NovaServiceProvider.php`:

```php

use Milkhan\NovaHelp\NovaHelp;

...

/**
 * Get the tools that should be listed in the Nova sidebar.
 *
 * @return array
 */
public function tools()
{
    return [
        // other tools
        new NovaHelp,
    ];
}
```

## Using this tool

* After all of this tool's assets have been published, there should be two `.md` (markdown) files placed within a help directory at the base of your `resources` directory.
    * If you would like to change this directory, change the `config('novahelp.home')` configuration definition.
    * By default, the "home page" entry point is `home.md`. Again if you would like to change that, be sure that you alter the `config('novahelp.home')` configuration.
* The sidebar navigation is constructed using two different elements: the name of the file and the title of within the file. This title is dynamically pulled from the first `# title` in each file.

### Linking

If you would like to link to other markdown files within your body content, outside of the sidebar, be sure to use **relative links**. For example if you are linking from the home page to a sub-directory based file called authentication, you would link to it like so:

```md
[authentication](authentication/base.md)
```

The tool will dynamically replace this link.

## Configuration

The configuration items listed below can be found in the `novahelp.php` configuration file.

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The name/title of this tool that will appear on the home page and within
    | the navigation.
    |
    */

    'title' => 'Help',

    /*
    |--------------------------------------------------------------------------
    | Markdown Flavor
    |--------------------------------------------------------------------------
    |
    | The flavor/style of markdown that will be used. The GitHub flavor is the
    | default as it supports code blocks and other "common" uses.
    |
    */

    'flavor' => 'github',

    /*
    |--------------------------------------------------------------------------
    | Home Page
    |--------------------------------------------------------------------------
    |
    | The markdown document that will be used as the home page and/or entry
    | point. This will be located within the documentation directory that resides
    | within your application's resources directory.
    |
    */

    'home' => 'help/home.md',

];
```

## License

The Nova Help tool is free software licensed under the MIT license.

## Credits
* [Milkhan](https://github.com/milkhan)
* [Doug Niccum](https://github.com/dniccum)
