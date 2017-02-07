# Validator

The Validator MediaWiki extension, provides a parameter processing
framework that provides a way to declaratively define a set of parameters and how they
should be processed. It can take such declarations together with a list of raw
parameters and provide the processed values.

The functionality provided by this extension largely comes from the [ParamProcessor library]
(https://github.com/JeroenDeDauw/ParamProcessor).

[![Build Status](https://travis-ci.org/JeroenDeDauw/Validator.svg?branch=master)](https://travis-ci.org/JeroenDeDauw/Validator)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JeroenDeDauw/Validator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JeroenDeDauw/Validator/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/JeroenDeDauw/Validator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/JeroenDeDauw/Validator/?branch=master)
[![Dependency Status](https://www.versioneye.com/php/mediawiki:validator/badge.png)](https://www.versioneye.com/php/mediawiki:validator)

On [Packagist](https://packagist.org/packages/mediawiki/validator):
[![Latest Stable Version](https://poser.pugx.org/mediawiki/validator/version.png)](https://packagist.org/packages/mediawiki/validator)
[![Download count](https://poser.pugx.org/mediawiki/validator/d/total.png)](https://packagist.org/packages/mediawiki/validator)

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `mediawiki/validator` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
Validator 2.0:

    {
        "require": {
            "mediawiki/validator": "2.0.*"
        }
    }

### Manual

Get the Validator code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the Validator extension by including its entry point:
Validator.php.

Simply include the entry point in your LocalSettings.php file:

```php
require_once( "$IP/extensions/Validator/Validator.php" );
```

## Authors

Validator has been written by
[Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw)
to support [Maps](https://github.com/JeroenDeDauw/Maps)
and [Semantic MediaWiki](https://semantic-mediawiki.org/).

## Release notes

### Version 2.0.6 (2016-07-01)

* Added missing system message
* Translation updates
* Fixed failing test (only the test itself had an issue)

### Version 2.0.5 (2016-04-04)

* Translation updates
* Compatibility with PHP 7 has now been tested

### Version 2.0.4 (2014-06-25)

* Updated used ParamProcessor version from ~1.0.0 to ~1.1

### Version 2.0.3 (2014-06-16)

* Removed obsolete magic words internationalization file

### Version 2.0.2 (2014-06-14)

* Fixed issue in deprecated ParserHook class

### Version 2.0.1 (2014-06-14)

* Removed #listerrors and #describe parser hooks

### Version 2.0 (2014-06-14)

* Dropped deprecated class aliases
* Dropped deprecated ParamProcessor.php entry point
* Use composer based autoloading
* Added TravisCI and ScrutinizerCI integration
* Changed minimum MediaWiki version from 1.16 to 1.17
* Migrated messages to the new MediaWiki i18n JSON format

### Version 1.0.1 (2014-03-25)

* Translation updates
* Main copy of the source code is now on GitHub

### Version 1.0 (2013-11-21)

This release is primarily a redesign of many internal APIs aimed at greater
stability and cleaner interfaces exposed to the outside.

Most code has been moved to the new [ParamProcessor library]
(https://github.com/JeroenDeDauw/ParamProcessor), leaving the Validator extension
as a thin MediaWiki specific wrapper.

##### Compatibility changes

* The ParamProcessor library is now required, version 1.0 or later.
* Changed minimum MediaWiki version from 1.16 to 1.18.
* Full compatibility with MediaWiki 1.20, 1.21, 1.22 and forward-compatibility with 1.23.
* Added compatibility with PHP 5.4.x and PHP 5.5.x
* Dropped support for Validator 0.4.x parameter definitions, including Criteria and Manipulations

##### Deprecations

* Deprecated the ParserHook class
* Deprecated the describe parser hook
* Deprecated the listerrors parser hook

### Version 0.5.1 (2012-11-21)

* Added compatibility with PHP 5.4.

### Version 0.5 (2012-10-05)

##### Compatibility changes

* Changed minimum MediaWiki version from 1.16 to 1.17.
* Full compatibility with MediaWiki 1.19 and MediaWiki 1.20 and forward-compatibility with 1.21.

#### New features

* New light-weight array definition of ParamDefinition objects supported.
* Added DimensionParam.
* Added ValidatorOptions class of which an instance can be passed to Validator
to globally change precessing behaviour. The most notable new option is the
'rawStringParameters' one, which when set to true (default) will expect values
in string format, and when set to false (new capability) will expect values
in their native formats (ie lists should be actual array objects).

#### Enhancements

* Split Parameter into Param and ParamDefinition classes.
    * ParamDefinition objects each represent a type and contain the
logic to validate and manipulate values.
   * Param objects hold a ParamDefinition, the user provided value,
and processing state.
* Added several new options to various of the ParamDefinition objects that
where not available in earlier criteria and manipulation objects.
* Added tests for all ParamDefinition objects.
* Added high level tests for Validator and tests for ValidatorOptions.

#### Deprecations

* Deprecated Parameter (and deriving) classes.
* Deprecated ParameterCriterion (and deriving) classes.
* Deprecated ParameterManipulation (and deriving) classes.
* Deprecated the constructor method of the Validator class.

### Version 0.4.14 (2012-03-10)

* New built-in parameter type 'title'. Accepts existing and non-existing page titles which are valid within the wiki.

### Version 0.4.13 (2011-11-30)

* ParserHook::$parser now is a reference to the original parser object, as one would suspect.
  Before this has only been the case for tag extension but not for parser function calls.

* if SFH_OBJECT_ARGS and therefore object parser function arguments are available in the MW
  version used with Validator, ParserHook::$frame will not be null anymore. Therefore a new
  function ParserHook::renderFunctionObj() is introduced, handling these SFH_OBJECT_ARGS hooks.

* ParserHook constructor now accepts a bitfield for flags to define further customization for
  registered Hooks. First option can be set via ParserHook::FH_NO_HASH to define that the function
  hook should be callable without leading hash ("{{plural:...}}"-like style).

* Option for unnamed parameter handling to work without named fallback. This allows to ignore '='
  within parameter values entirely, these parameters bust be set before any named parameter then.
  See Validator::setFunctionParams() and ParserHook::getParameterInfo() for details.

* ParserHook Validation messages will now output text in global content language instead of users interface language.

### Version 0.4.12 (2011-10-15)

* Internationalization fix in the describe parser hook.

### Version 0.4.11 (2011-09-14)

* Fixed compatibility fallback in Parameter::getDescription.
* Fixed handling of list parameters in ParameterInput.

### Version 0.4.10 (2011-08-04)

* Added language parameter to describe that allows setting the lang for the generated docs.
* Added getMessage method to ParserHook class for better i18n.

### Version 0.4.9 (2011-07-30)

* Added setMessage and getMessage methods to Parameter class for better i18n.

### Version 0.4.8 (2011-07-19)

* Added unit tests for the criteria.
* Fixed issue with handling floats in CriterionInRange.
* Added support for open limits in CriterionHasLength and CriterionItemCount.

### Version 0.4.7 (2011-05-15)

* Added ParameterInput class to generate HTML inputs for parameters, based on code from SMWs Special:Ask.
* Added "$manipulate = true" as second parameter for Parameter::setDefault,
  which gets passed to Parameter::setDoManipulationOfDefault.
* Boolean manipulation now ignores values that are already a boolean.

### Version 0.4.6 (2011-03-21)

* Removed ParamManipulationBoolstr.
* Added method to get the allowed values to CriterionInArray.
* Added automatic non-using of boolean manipulation when a boolean param was defaulted to a boolean value.
* Parameter fix in ListParameter::setDefault, follow up to change in 0.4.5.

### Version 0.4.5 (2011-03-05)

* Escaping fix in the describe parser hook.
* Added string manipulation, applied by default on strings and chars.

### Version 0.4.4 (2011-02-16)

* Tweaks to parser usage in the ParserHook class.
* Fixed incorrect output of nested pre-tags in the describe parser hook.

### Version 0.4.3.1 (2011-01-20)

* Removed underscore and space switching behavior for tag extensions and parser functions.

### Version 0.4.3 (2011-01-11)

* Added describe parser hook that enables automatic documentation generation of parser hooks defined via Validator.
* Modified the ParserHook and Parameter classes to allow specifying a description message.

### Version 0.4.2 (2010-10-28)

* Fixed compatibility with MediaWiki 1.15.x.
* Removed the lowerCaseValue field in the Parameter class and replaced it's functionality with a ParameterManipulation.

### Version 0.4.1 (2010-10-20)

* Made several small fixes and improvements.

### Version 0.4 (2010-10-15)

##### New features

* Added ParserHook class that allows for out-of-the-box parser function and tag extension creation
with full Validator support.
* Added listerrors parser hook that allows you to list all validation errors that occurred at the point it's rendered.
* Added support for conditional parameter adding.

##### Refactoring

Basically everything got rewritten...

* Added Parameter and ListParameter classes to replace parameter definitions in array form.
* Added ParameterCriterion and ListParameterCriterion classes for better handling of parameter criteria.
* Added ParameterManipulation and ListParameterManipulation classes for more structured formatting of parameters.
* Added ValidationError class to better describe errors.
* Replaced the error level enum by ValidationError::SEVERITY_ and ValidationError::ACTION_, which are linked in $egErrorActions.

### Version 0.3.6 (2010-08-26)

* Added support for 'tolower' argument in parameter info definitions.

### Version 0.3.5 (2010-07-26)

* Fixed issue with the original parameter name (and in some cases also value) in error messages.

### Version 0.3.4 (2010-07-07)

* Fixed issue with parameter reference that occurred in php 5.3 and later.
* Fixed escaping issue that caused parameter names in error messages to be shown incorrectly.
* Fixed small issue with parameter value trimming that caused problems when objects where passed.

### Version 0.3.3 (2010-06-20)

* Fixed bug that caused notices when using the ValidatorManager::manageParsedParameters method in some cases.

### Version 0.3.2 (2010-06-07)

* Added lower casing to parameter names, and optionally, but default on, lower-casing for parameter values.
* Added removal of default parameters from the default parameter queue when used as a named parameter.

### Version 0.3.1 (2010-06-04)

* Added ValidatorManager::manageParsedParameters and Validator::setParameters.

### Version 0.3 (2010-05-31)

* Added generic default parameter support.
* Added parameter dependency support.
* Added full meta data support for validation and formatting functions, enabling more advanced handling of parameters.
* Major refactoring to conform to MediaWiki convention.

### Version 0.2.2 (2010-03-01)

* Fixed potential xss vectors.
* Minor code improvements.

### Version 0.2.1 (2010-02-01)

* Changed the inclusion of the upper bound for range validation functions.
* Small language fixes.

### Version 0.2 (2009-12-25)

* Added handling for lists of a type, instead of having list as a type. This includes per-item-validation and per-item-defaulting.
* Added list validation functions: item_count and unique_items
* Added boolean, number and char types.
* Added support for output types. The build in output types are lists, arrays, booleans and strings. Via a hook you can add your own output types.
* Added Validator_ERRORS_MINIMAL value for $egValidatorErrorLevel.
* Added warning message to ValidatorManager that will be shown for errors when egValidatorErrorLevel is Validator_ERRORS_WARN.
* Added criteria support for is_boolean, has_length and regex.

### Version 0.1 (2009-12-17)

* Initial release, featuring parameter validation, defaulting and error generation.

## Links

* [Validator on Packagist](https://packagist.org/packages/mediawiki/validator)
* [Validator on Ohloh](https://www.ohloh.net/p/validator)
* [Validator on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:Validator)
