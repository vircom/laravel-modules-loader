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

```

## Configuration
