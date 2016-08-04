# DataValues Common

DataValues Common is a small library build on top of DataValues that provides common
implementations of the DataValues, ValueParsers, ValueFormatters and ValueValidators interfaces.

It is part of the [DataValues set of libraries](https://github.com/DataValues).

[![Build Status](https://secure.travis-ci.org/DataValues/Common.png?branch=master)](http://travis-ci.org/DataValues/Common)
[![Code Coverage](https://scrutinizer-ci.com/g/DataValues/Common/badges/coverage.png?s=728b9287ebdd13fbe15255d4d55575c5b5d47b8f)](https://scrutinizer-ci.com/g/DataValues/Common/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/DataValues/Common/badges/quality-score.png?s=3195539d2e929aafaefb4bc006fb0da6c09a4d2a)](https://scrutinizer-ci.com/g/DataValues/Common/)

On [Packagist](https://packagist.org/packages/data-values/common):
[![Latest Stable Version](https://poser.pugx.org/data-values/common/version.png)](https://packagist.org/packages/data-values/common)
[![Download count](https://poser.pugx.org/data-values/common/d/total.png)](https://packagist.org/packages/data-values/common)

## Installation

The recommended way to use this library is via [Composer](http://getcomposer.org/).

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/common` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
version 0.3 of this package:

    {
        "require": {
            "data-values/common": "0.3.*"
        }
    }

### Manual

Get the code of this package, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Then take care of autoloading the classes defined in the src directory.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataValues Common has been written by the Wikidata team, as [Wikimedia Germany]
(https://wikimedia.de) employees for the [Wikidata project](https://wikidata.org/).

## Release notes

### 0.3.1 (2015-08-14)

* The component can now be installed together with DataValues Interfaces 0.1.5

### 0.3.0 (2015-08-11)

* Added `DispatchingValueParser`
* Added `StringNormalizer` interface
* Added `NullStringNormalizer`
* Added `StringParser`
* Dropped deprecated constant `DataValuesCommon_VERSION`, use `DATAVALUES_COMMON_VERSION` instead
* Dropped `ValueParserTestBase::getParserClass`
* Dropped `ValueParserTestBase::newParserOptions`
* Made `ValueParserTestBase::getInstance` abstract
* Made `ValueParserTestBase::invalidInputProvider` abstract
* Lowered visibility of all class fields to private

### 0.2.3 (2014-10-09)

* Introduced `FORMAT_NAME` class constants on ValueParsers in order to use them as expectedFormat
* Changed ValueParsers to pass rawValue and expectedFormat arguments when constructing a `ParseException`
* Installation together with DataValues 1.x is now supported

### 0.2.2 (2014-04-11)

* Introduced `DataValueMismatchException`

### 0.2.1 (2014-03-12)

* Minor code cleanup
* Improved PHPUnit bootstrap

### 0.2 (2013-12-16)

* Added FloatParser (moved from data-values/number)
* Added IntParser (moved from data-values/number)

### 0.1.1 (2013-11-22)

* Fixed link in the MediaWiki credits

### 0.1 (2013-11-17)

Initial release with these features:

* Several DataValue implementations
	* MonolingualTextValue
	* MultilingualTextValue
* Several ValueFormatter implementations
	* StringFormatter
* Several ValueParser implementations
	* BoolParser
	* DecimalParser
	* NullParser

## Links

* [DataValues Common on Packagist](https://packagist.org/packages/data-values/common)
* [DataValues Common on TravisCI](https://travis-ci.org/DataValues/Common)
