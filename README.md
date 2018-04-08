# Asset

*By [endroid](https://endroid.nl/)*

[![Latest Stable Version](http://img.shields.io/packagist/v/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)
[![Build Status](http://img.shields.io/travis/endroid/asset.svg)](http://travis-ci.org/endroid/asset)
[![Total Downloads](http://img.shields.io/packagist/dt/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)
[![License](http://img.shields.io/packagist/l/endroid/asset.svg)](https://packagist.org/packages/endroid/asset)

Library for easy asset management. An asset can be used as an intermediate
resource that can be resolved as a string without worrying about the inner
workings on how the string is generated. The library offers the following types.

* ControllerAsset: generates the string from a controller action and parameters.
* TemplateAsset: generates the string from a template and parameters.
* FileAsset: generates the string by loading the contents of a file.
* DataAsset: simply contains a string which is returned when requested.
* CachedAsset: wraps any of the above in a cache to optimize performance.

## Installation

## Usage

## Versioning

Version numbers follow the MAJOR.MINOR.PATCH scheme. Backwards compatible
changes will be kept to a minimum but be aware that these can occur. Lock
your dependencies for production and test your code when upgrading.

## License

This bundle is under the MIT license. For the full copyright and license
information please view the LICENSE file that was distributed with this source code.
