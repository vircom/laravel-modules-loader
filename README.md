Laravel modules loader library
=========

[vircom/laravel-modules-loader] is a Laravel package allows you to easy loads modules used in your application.


## Installation
The recommended way to install Laravel modules loader library is through [Composer](http://getcomposer.org/).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, you should run command below, to install the latest stable version of package:

```bash
composer.phar require vircom/laravel-modules-loader
```

Next add the following service provider in `config/app.php`.

```php
'providers' => [
  VirCom\Laravel\ModulesLoader\ModulesLoaderServiceProvider::class,
],
```

At least, public modules configuration file:
```bash
php artisan vendor:publish --provider="VirCom\Laravel\ModulesLoader\ModulesLoaderServiceProvider"
```

## Configuration
Controllers, repositories and other module code parts are not loaded by default.
At first, you should add to your **composer.json** lines, to load PSR-4 files. Example:
```php
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "YourVendor\\ModuleName\\SubmoduleName\\Module\\": "modules/Module/src/"
    }
  }
}
```

Dont forget to run command:
```bash
composer dump-autoload
```

After that, create **modules** directory and module structre inside it:
```
modules
+-- src
|   +-- Module.php
```

**Module.php** file must be subclass of Illuminate\Support\ServiceProvider larvel provider class.
So for example, looks like below:

```php
<?php

namespace YourVendor\ModuleName\SubmoduleName\Module;

use Illuminate\Support\ServiceProvider;

class Module extends ServiceProvider
{
    
    public function register()
    {
    
    }
}
```

At least, add the following line to your: config\modules.php file:
```php
return [
    /*
    |--------------------------------------------------------------------------
    | Modules list
    |--------------------------------------------------------------------------
    |
    | List all of you modules
    */
    
    'YourVendor\ModuleName\SubmoduleName\Module'
];
```

Thats all. Modules loader automaticly register your module service file.
