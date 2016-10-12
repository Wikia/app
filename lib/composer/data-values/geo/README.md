# DataValues Geo

Library containing value objects to represent geographical information, parsers to turn user input
into such value objects, and formatters to turn them back into user consumable representations.

It is part of the [DataValues set of libraries](https://github.com/DataValues).

[![Build Status](https://secure.travis-ci.org/DataValues/Geo.png?branch=master)](http://travis-ci.org/DataValues/Geo)
[![Code Coverage](https://scrutinizer-ci.com/g/DataValues/Geo/badges/coverage.png?s=bf4cfd11f3b985fd05918f395c350b376a9ce0ee)](https://scrutinizer-ci.com/g/DataValues/Geo/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/DataValues/Geo/badges/quality-score.png?s=e695e42b53d74fc02e5cfa2aa218420f062edbd2)](https://scrutinizer-ci.com/g/DataValues/Geo/)
[![Dependency Status](https://www.versioneye.com/php/data-values:geo/badge.png)](https://www.versioneye.com/php/data-values:geo)

On [Packagist](https://packagist.org/packages/data-values/geo):
[![Latest Stable Version](https://poser.pugx.org/data-values/geo/version.png)](https://packagist.org/packages/data-values/geo)
[![Download count](https://poser.pugx.org/data-values/geo/d/total.png)](https://packagist.org/packages/data-values/geo)

## Installation

The recommended way to use this library is via [Composer](http://getcomposer.org/).

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `data-values/geo` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
version 1.1 of this package:

    {
        "require": {
            "data-values/geo": "1.1.*"
        }
    }

### Manual

Get the code of this package, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Then take care of autoloading the classes defined in the src directory.

## Library functionality

#### Value objects

These are simple value objects. They all implement the <code>DataValues\DataValue</code> interface.

* <code>LatLongValue</code> - Object representing a geographic point specified by latitude and longitude.
* <code>GlobeCoordinateValue</code> - Geographical coordinate with precision and globe.

#### Formatters

These turn value objects into string representations.
They all implement the <code>ValueFormatters\ValueFormatter</code> interface.

* <code>GeoCoordinateFormatter</code> - Formats a LatLongValue into float, decimal minute,
decimal degree or degree minute second notation. Both directional and non-directional notation
are supported. Directional labels, latitude-longitude separator and precision can be specified.
* <code>GlobeCoordinateFormatter</code> - Formats a GlobeCoordinateValue.

#### Parsers

These turn string representations into value objects.
They all implement the <code>ValueParsers\ValueParser</code> interface.

Simple parsers:

* <code>DdCoordinateParser</code> - Parses decimal degree coordinates into LatLongValue objects.
* <code>DmCoordinateParser</code> - Parses decimal minute coordinates into LatLongValue objects.
* <code>DmsCoordinateParser</code> - Parses degree minute second coordinates into LatLongValue objects.
* <code>FloatCoordinateParser</code> - Parses float coordinates into LatLongValue objects.

Composite parsers:

* <code>GeoCoordinateParser</code> - Facade for DdCoordinateParser, DmCoordinateParser, DmsCoordinateParser
and FloatCoordinateParser. Parses a coordinate in any of the notations supported by these parsers
into a LatLongValue object. Both directional and non-directional notation are supported. Directional
labels and the latitude-longitude separator can be specified.
* <code>GlobeCoordinateParser</code> - Parses coordinates into GlobeCoordinateValue objects.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

DataValues Geo has been written by the Wikidata team, as [Wikimedia Germany]
(https://wikimedia.de) employees for the [Wikidata project](https://wikidata.org/).

It is based upon and contains a lot of code written by [Jeroen De Dauw]
(https://github.com/JeroenDeDauw) for the [Maps](https://github.com/JeroenDeDauw/Maps) and
[Semantic MediaWiki](https://semantic-mediawiki.org/) projects.

## Release notes

### 1.1.7 (2016-05-25)

* Made minor documentation improvements

### 1.1.6 (2016-04-02)

* Added compatibility with DataValues Common 0.3.x

### 1.1.5 (2015-12-28)

* The component can now be installed together with DataValues Interfaces 0.2.x

### 1.1.4 (2014-11-25)

* Add fall back to default on invalid precision to more places.

### 1.1.3 (2014-11-19)

* Fall back to default on invalid precision instead of dividing by zero.

### 1.1.2 (2014-11-18)

* Precision detection in `GlobeCoordinateParser` now has a lower bound of 0.00000001°

### 1.1.1 (2014-10-21)

* Removed remaining uses of class aliases from messages and comments
* Fixed some types in documentation

### 1.1 (2014-10-09)

* Made the component installable with DataValues 1.x
* `GeoCoordinateFormatter` now supports precision in degrees
* `GlobeCoordinateFormatter` now passes the globe precision to the `GeoCoordinateFormatter` it uses
* Introduced `FORMAT_NAME` class constants on ValueParsers in order to use them as expectedFormat
* Changed ValueParsers to pass rawValue and expectedFormat arguments when constructing a `ParseException`

### 1.0 (2014-07-31)

* All classes and interfaces have been moved into the `DataValues\Geo` namespace
    * `DataValues\LatLongValue` has been left as deprecated alias
    * `DataValues\GlobeCoordinateValue` has been left as deprecated alias
* Globe in `GlobeCoordinateValue` now defaults to `http://www.wikidata.org/entity/Q2`

### 0.2 (2014-07-07)

* Removed deprecated `GeoCoordinateValue`
* Added `GlobeMath`

### 0.1.2 (2014-01-22)

* Added support for different levels of spacing in GeoCoordinateFormatter

### 0.1.1 (2013-11-30)

* Added support for direction notation to GeoCoordinateFormatter
* Decreased complexity of GeoCoordinateFormatter
* Decreased complexity and coupling of GeoCoordinateFormatterTest

### 0.1 (2013-11-17)

Initial release with these features:

* LatLongValue
* GlobeCoordinateValue
* GeoCoordinateFormatter
* GlobeCoordinateFormatter
* DdCoordinateParser
* DmCoordinateParser
* DmsCoordinateParser
* FloatCoordinateParser
* GeoCoordinateParser
* GlobeCoordinateParser

## Links

* [DataValues Geo on Packagist](https://packagist.org/packages/data-values/geo)
* [DataValues Geo on TravisCI](https://travis-ci.org/DataValues/Geo)
* [DataValues on Wikimedia's Phabricator](https://phabricator.wikimedia.org/project/view/122/)
