# DataValues

DataValues is a small PHP library that aims to be a common foundation for representing "simple"
values. Values such as numbers, geographical coordinates, strings and times.

It is part of the [DataValues set of libraries](https://github.com/DataValues).

[![Build Status](https://secure.travis-ci.org/DataValues/DataValues.png?branch=master)](http://travis-ci.org/DataValues/DataValues)
[![Code Coverage](https://scrutinizer-ci.com/g/DataValues/DataValues/badges/coverage.png?s=56a1ea89df94c6d9b4223ba584d0d4556e1984ef)](https://scrutinizer-ci.com/g/DataValues/DataValues/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/DataValues/DataValues/badges/quality-score.png?s=ba9364790e6b521277a3829ffb91e2c2e1b68c3c)](https://scrutinizer-ci.com/g/DataValues/DataValues/)

On [Packagist](https://packagist.org/packages/data-values/data-values):
[![Latest Stable Version](https://poser.pugx.org/data-values/data-values/version.png)](https://packagist.org/packages/data-values/data-values)
[![Download count](https://poser.pugx.org/data-values/data-values/d/total.png)](https://packagist.org/packages/data-values/data-values)

## Requirements

* PHP 5.3 or later

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/data-values` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
DataValues 1.0:

    {
        "require": {
            "data-values/data-values": "1.0.*"
        }
    }

### Manual

Get the DataValues code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the DataValues library by including its entry point:
DataValues.php.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataValues has been written primarily by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw),
in part as [Wikimedia Germany](https://wikimedia.de) employee for the [Wikidata project](https://wikidata.org/).

Contributions where also made by [several other awesome people]
(https://www.ohloh.net/p/datavalues/contributors).

## Release notes

### 1.0 (2014-09-26)

* The CI now ensures compatibility with PHP 5.6 and HHVM
* A lot of type hints where improved
* Protected methods and fields where changed to private
* The test bootstrap no longer executes `composer update`
* The test bootstrap now sets PHP strict mode
* The contract of the `Hashable::getHash` method was updated
* The MediaWiki internationalization support has been migrated to the JSON based version

### 0.1.1 (2013-11-22)

* Removed support for running the tests via the MediaWiki test runner.
* The test bootstrapping file now automatically does a composer install.
* Removed custom autoloader in favour of defining autoloading in composer.json.

### 0.1 (2013-11-16)

Initial release with these features:

* DataValue interface
	* BooleanValue implementation
	* NumberValue implementation
	* StringValue implementation
	* UnDeserializableValue implementation
	* UnknownValue implementation
* Common interface definitions: Comparable, Copyable, Hashable, Immutable

## Links

* [DataValues on Packagist](https://packagist.org/packages/data-values/data-values)
* [DataValues on Ohloh](https://www.ohloh.net/p/datavalues)
