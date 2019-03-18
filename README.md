# Asset

*By [endroid](https://endroid.nl/)*

[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)
[![Build Status](http://img.shields.io/travis/endroid/asset.svg)](http://travis-ci.org/endroid/asset)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)
[![License](http://img.shields.io/packagist/l/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)

Library for quick and easy asset management.

Read the [blog](https://medium.com/@endroid/pdf-generation-in-symfony-3080702353b)
for more information on why I created this library.

* ControllerAsset: generates the string from a controller action and parameters.
* TemplateAsset: generates the string from a template and parameters.
* FileAsset: generates the string by loading the contents of a file.
* UrlAsset: simply contains a string which is returned when requested.
* DataAsset: simply contains a string which is returned when requested.
* CacheAsset: wraps any of the above in a cache to optimize performance.

All implement AssetInterface and provide the method: getData().

## Usage

The easiest way to work with assets is by letting the factory create assets for
you. This allows you to create your assets without worrying about the necessary
dependencies.

```php
$dataAsset = $assetFactory->create([
   'controller' => CoverController::class,
   'parameters' => ['title' => 'My PDF', 'date' => new DateTime()],
   'cache_key' => 'cover',
   'cache_expires_after' => 3600,
   'cache_clear' => true, // use to purge any previously cached data
]);
```

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require endroid/asset
```

When you use Symfony, the [installer](https://github.com/endroid/installer)
makes sure that services are automatically wired. If this is not the case you
can find the configuration files in the `.install/symfony` folder.

## Versioning

Version numbers follow the MAJOR.MINOR.PATCH scheme. Backwards compatible
changes will be kept to a minimum but be aware that these can occur. Lock
your dependencies for production and test your code when upgrading.

## License

This bundle is under the MIT license. For the full copyright and license
information please view the LICENSE file that was distributed with this source code.
