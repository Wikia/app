# DataValues Interfaces

DataValues Interfaces is a small PHP library that defines a set of interfaces for parsers,
formatters and validators.

It is part of the [DataValues set of libraries](https://github.com/DataValues).

[![Build Status](https://secure.travis-ci.org/DataValues/Interfaces.png?branch=master)](http://travis-ci.org/DataValues/Interfaces)
[![Code Coverage](https://scrutinizer-ci.com/g/DataValues/Interfaces/badges/coverage.png?s=6432d29bf3fed068995e66093ad52e053099a916)](https://scrutinizer-ci.com/g/DataValues/Interfaces/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/DataValues/Interfaces/badges/quality-score.png?s=da1bb6ea09762d9e3a143e473cdefa712db46804)](https://scrutinizer-ci.com/g/DataValues/Interfaces/)

On [Packagist](https://packagist.org/packages/data-values/interfaces):
[![Latest Stable Version](https://poser.pugx.org/data-values/interfaces/version.png)](https://packagist.org/packages/data-values/interfaces)
[![Download count](https://poser.pugx.org/data-values/interfaces/d/total.png)](https://packagist.org/packages/data-values/interfaces)

## Requirements

* PHP 5.3 or later

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/interfaces` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
DataValues Interfaces 0.2:

    {
        "require": {
            "data-values/interfaces": "0.2.*"
        }
    }

### Manual

Get the DataValues Interfaces code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the DataValues Interfaces library by including its entry point:
Interfaces.php.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataValues Interfaces has been written by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw),
as [Wikimedia Germany](https://wikimedia.de) employee for the [Wikidata project](https://wikidata.org/).

## Release notes

### 0.2.2 (2016-07-15)

* Fixed `ValueFormatterTestBase` not doing strict string comparisons.

### 0.2.1 (2016-01-13)

* Fixed an issue when using this component with HHVM 1.11.0 (see #21).

### 0.2.0 (2015-08-11)

* Dropped deprecated `ErrorObject`, use `Error` instead
* Dropped deprecated `ResultObject`, use `Result` instead
* Dropped deprecated constant `DataValuesInterfaces_VERSION`, use `DATAVALUES_INTERFACES_VERSION` instead
* Dropped `ValueFormatterTestBase::getFormatterClass`
* Made `ValueFormatterTestBase::getInstance` abstract
* The options in `ValueFormatterTestBase::getInstance` are now optional

### 0.1.5 (2015-02-14)

* The options in the `ValueFormatterBase` constructor are now optional
* The MediaWiki extension registration now includes the license

### 0.1.4 (2014-04-14)

* Added rawValue and expectedFormat arguments to `ValueParsers\ParseException`

### 0.1.3 (2014-03-31)

* Added `ValueFormatters\FormattingException`

### 0.1.2 (2013-11-22)

* Improved autoloading code
* Fixed link in MediaWiki credits
* Renamed entry point from DataValuesInterfaces.php to Interfaces.php

### 0.1.0 (2013-11-16)

Initial release with these features:

* `ValueFormatters\ValueFormatter` interface
* `ValueParsers\ValueParser` interface
* `ValueValidators\ValueValidator` interface

## Links

* [DataValues Interfaces on Packagist](https://packagist.org/packages/data-values/interfaces)
