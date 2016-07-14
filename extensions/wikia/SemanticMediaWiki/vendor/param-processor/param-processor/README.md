# ParamProcessor

ParamProcessor is a parameter processing library that provides a way to
decoratively define a set of parameters and how they should be processed.
It can take such declarations together with a list of raw parameters and
provide the processed values. For example, if one defines a parameter to
be an integer, in the range `[0, 100]`, then ParamProcessor will verify the
input is an integer, in the specified range, and return it as an actual
integer variable.

[![Build Status](https://secure.travis-ci.org/JeroenDeDauw/ParamProcessor.png?branch=master)](http://travis-ci.org/JeroenDeDauw/ParamProcessor)
[![Code Coverage](https://scrutinizer-ci.com/g/JeroenDeDauw/ParamProcessor/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/JeroenDeDauw/ParamProcessor/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JeroenDeDauw/ParamProcessor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JeroenDeDauw/ParamProcessor/?branch=master)
[![Dependency Status](https://www.versioneye.com/php/param-processor:param-processor/badge.png)](https://www.versioneye.com/php/param-processor:param-processor)


On [Packagist](https://packagist.org/packages/param-processor/param-processor):
[![Latest Stable Version](https://poser.pugx.org/param-processor/param-processor/version.png)](https://packagist.org/packages/param-processor/param-processor)
[![Download count](https://poser.pugx.org/param-processor/param-processor/d/total.png)](https://packagist.org/packages/param-processor/param-processor)

## Installation

The recommended way to use this library is via [Composer](http://getcomposer.org/).

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `param-processor/param-processor` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
version 1.x of this package:

```js
{
    "require": {
        "param-processor/param-processor": "~1.0"
    }
}
```

### Manual

Get the code of this package, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Then take care of autoloading the classes defined in the src directory.

## Concept

The goal of the ParamProcessor library is to make parameter handling simple and consistent.

In order to achieve this, a declarative API for defining parameters is provided. Passing in
such parameter definitions together with a list of raw input into the processor leads to
a processed list of parameters. Processing consists out of name and alias resolving, parsing,
validation, formatting and defaulting.

If ones defines an "awesomeness" parameter of type "integer", one can be sure that at the end
of the processing, there will be an integer value for the awesomeness parameter. If the user did
not provide a value, or provided something that is invalid, while the parameter it is required,
processing will abort with a fatal error. If on the other hand there is a default, the default will
be set. If the value was invalid, a warning will be kept track of. In case the user provides a valid
value, for instance "42" (string), it will be turned in the appropriate 42 (int).

## Implementation structure

Parameters are defined using the `ParamProcessor\ParamDefinition` class. Users can also use the array
format to define parameters and not be bound to this class. At present, it is preferred to use this
array format as the class itself is not stable yet.

Processing is done via `ParamProcessor\Processor`.

## Defining parameters

### Array definition schema

These fields are supported:

<table>
	<tr>
		<th>Name</th>
		<th>Type</th>
		<th>Default</th>
		<th>Description</th>
	</tr>
	<tr>
		<th>name</th>
		<td>string</td>
		<td><i>required</i></td>
		<td></td>
	</tr>
	<tr>
		<th>type</th>
		<td>string (enum)</td>
		<td>string</td>
		<td></td>
	</tr>
	<tr>
		<th>default</th>
		<td>mixed</td>
		<td>null</td>
		<td>If this value is null, the parameter has no default and is required</td>
	</tr>
	<tr>
		<th>aliases</th>
		<td>array of string</td>
		<td>empty array</td>
		<td>Aliases for the name</td>
	</tr>
	<tr>
		<th>trim</th>
		<td>boolean</td>
		<td><i>inherited from processor options</i></td>
		<td>If the value should be trimmed</td>
	</tr>
	<tr>
		<th>islist</th>
		<td>boolean</td>
		<td>false</td>
		<td></td>
	</tr>
	<tr>
		<th>delimiter</th>
		<td>string</td>
		<td>,</td>
		<td>The delimiter between values if it is a list</td>
	</tr>
	<tr>
		<th>manipulatedefault</th>
		<td>boolean</td>
		<td>true</td>
		<td>If the default value should also be manipulated</td>
	</tr>
	<tr>
		<th>values</th>
		<td>array</td>
		<td></td>
		<td>Allowed values</td>
	</tr>
	<tr>
		<th>message</th>
		<td>string</td>
		<td><i>required</i></td>
		<td></td>
	</tr>
	<tr>
		<th>post-format</th>
		<td>callback</td>
		<td><i>none</i></td>
		<td>Takes the value as only parameter and returns the new value</td>
	</tr>
	
</table>

The requires fields currently are: name and message

### Core parameter types

<table>
	<tr>
		<th>Name</th>
		<th>PHP return type</th>
		<th>Description</th>
	</tr>
	<tr>
		<th>boolean</th>
		<td>boolean</td>
		<td>Accepts "yes", "no", "on", "off", "true" and "false"</td>
	</tr>
	<tr>
		<th>float</th>
		<td>float</td>
		<td></td>
	</tr>
	<tr>
		<th>integer</th>
		<td>integer</td>
		<td></td>
	</tr>
	<tr>
		<th>string</th>
		<td>string</td>
		<td></td>
	</tr>
	<tr>
		<th>coordinate</th>
		<td>DataValues\LatLongValue</td>
		<td></td>
	</tr>
	<tr>
		<th>dimension</th>
		<td>string</td>
		<td>Value for a width or height attribute in HTML</td>
	</tr>
</table>

## Defining parameter types

* <code>string-parser</code> Name of a class that implements the `ValueParsers\ValueParser` interface
* <code>validation-callback</code> Callback that gets the raw value as only parameter and returns a boolean
* <code>validator</code> Name of a class that implements the `ValueValidators\ValueValidator` interface

## Examples

### Parameter definitions

```php
$paramDefintions = array();

$paramDefintions[] = array(
    'name' => 'username',
);

$paramDefintions[] = array(
    'name' => 'job',
    'default' => 'unknown',
    'values' => array( 'Developer', 'Designer', 'Manager', 'Tester' ),
);

$paramDefintions[] = array(
    'name' => 'favourite-numbers',
    'islist' => true,
    'type' => 'int',
    'default' => array(),
);
```

### Processing

```php
$inputParams = array(
    'username' => 'Jeroen',
    'job' => 'Developer',
);

$processor = ParamProcessor\Processor::newDefault();

$processor->setParameters( $inputParams, $paramDefintions );

$processingResult = $processor->processParameters();

$processedParams = $processingResult->getParameters();
```

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Authors

ParamProcessor has been written by [Jeroen De Dauw](https://github.com/JeroenDeDauw) to
support the [Maps](https://github.com/JeroenDeDauw/Maps) and [Semantic MediaWiki]
(https://semantic-mediawiki.org/) projects.

## Release notes

### 1.2.2 (2014-10-24)

* Installation together with DataValues 1.x is now allowed.

### 1.2.0 (2014-09-12)

* Dropped dependency on DataValues Geo.

### 1.1.0 (2014-05-07)

* Dropped dependency on DataValues Time.
* Use PSR-4 based loading rather than PSR-0 based loading.
* Fixed Windows compatibility in PHPUnit bootstrap

### 1.0.2 (2013-12-16)

* Removed dependency on data-values/number
* Updated required version of data-values/common from ~0.1 to ~0.2.

### 1.0.1 (2013-11-29)

* Implemented ProcessingResult::hasFatal
* Added ProcessingResultTest

### 1.0.0 (2013-11-21)

First release as standalone PHP library.

## Links

* [ParamProcessor on Packagist](https://packagist.org/packages/param-processor/param-processor)
* [ParamProcessor on TravisCI](https://travis-ci.org/JeroenDeDauw/ParamProcessor)
* [ParamProcessor on ScrutinizerCI](https://scrutinizer-ci.com/g/JeroenDeDauw/ParamProcessor/)
* [MediaWiki extension "Validator"](https://www.mediawiki.org/wiki/Extension:Validator) -
a wrapper around this library for MediaWiki users
