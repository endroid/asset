# Asset

*By [endroid](https://endroid.nl/)*

[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)
[![Build Status](http://img.shields.io/travis/endroid/asset.svg)](http://travis-ci.org/endroid/asset)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)
[![License](http://img.shields.io/packagist/l/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)

Library for quick and easy asset management.

* ControllerAsset: generates the string from a controller action and parameters.
* TemplateAsset: generates the string from a template and parameters.
* FileAsset: generates the string by loading the contents of a file.
* UrlAsset: simply contains a string which is returned when requested.
* DataAsset: simply contains a string which is returned when requested.
* CacheAsset: wraps any of the above in a cache to optimize performance.

All implement AssetInterface and provide the method: getData().

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require endroid/asset
```

### Frameworks

The following frameworks will automatically be configured upon installation.

* Symfony 3.4+ (new directory structure)

Read the [endroid/installer](https://github.com/endroid/asset) documentation
if you have any installation issues.

## Usage

The easiest way to work with assets is by letting the factory create assets for
you. This allows you to create your assets without worrying about the necessary
dependencies.

```php
$dataAsset = $assetFactory->create([
    'data' => 'This is the data'
]);
```

## Versioning

Version numbers follow the MAJOR.MINOR.PATCH scheme. Backwards compatible
changes will be kept to a minimum but be aware that these can occur. Lock
your dependencies for production and test your code when upgrading.

## License

This bundle is under the MIT license. For the full copyright and license
information please view the LICENSE file that was distributed with this source code.
