# ParserHooks

[![Build Status](https://secure.travis-ci.org/JeroenDeDauw/ParserHooks.png?branch=master)](http://travis-ci.org/JeroenDeDauw/ParserHooks)
[![Coverage Status](https://coveralls.io/repos/wikimedia/mediawiki-extensions-ParserHooks/badge.png?branch=master)](https://coveralls.io/r/wikimedia/mediawiki-extensions-ParserHooks?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JeroenDeDauw/ParserHooks/badges/quality-score.png?s=2faf8e83be1e5ecd58a8f9f65cb47a01e966302e)](https://scrutinizer-ci.com/g/JeroenDeDauw/ParserHooks/)

On Packagist:
[![Latest Stable Version](https://poser.pugx.org/mediawiki/parser-hooks/version.png)](https://packagist.org/packages/mediawiki/parser-hooks)
[![Download count](https://poser.pugx.org/mediawiki/parser-hooks/d/total.png)](https://packagist.org/packages/mediawiki/parser-hooks)

OOP interface for creating MediaWiki parser hooks in a declarative fashion.

This is a PHP library for MediaWiki extensions. It does not in itself add or enhance functionality of your wiki.

## Requirements

* [PHP](http://php.net/) 5.3 or later (including PHP 7)
* [MediaWiki](https://www.mediawiki.org/) 1.16 or later

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `mediawiki/parser-hooks` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
ParserHooks 1.4:

    {
        "require": {
            "mediawiki/parser-hooks": "~1.5"
        }
    }

### Manual

Get the ParserHooks code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
Load all dependencies and the load the ParserHooks library by including its entry point:
ParserHooks.php.

## Usage

All classes are located in the ParserHooks namespace, which is PSR-0 mapped onto the src/ directory.

### General concept

The declarative OOP interface provided by this library allows you to define the signatures of
your parser hooks and the handlers for them separately. The library makes use of the parameters
specified in this definition to do parameter processing via the ParamProcessor library. This means
that the handler you write for your parser function will not need to care about what the name of
the parser function is, or how the parameters for it should be processed. It has a "sizes" parameter
that takes an array of positive integers? Your handler will always get an actual PHP array of integer
without needing to do any parsing, validation, defaulting, etc.

### HookDefinition

An instance of the HookDefinition class represents the signature of a parser hook. It defines
the name of the parser hook and the parameters (including their types, default values, etc) it
accepts. It does not define any behaviour, and is thus purely declarative. Instances of this
class are used in handling of actual parser hooks, though can also be used in other contexts.
For instance, you can feed these definitions to a tool that generates parser hook documentation
based on them.

The parameter definitions are ParamProcessor\ParamDefinition objects. See the [ParamProcessor]
(https://github.com/JeroenDeDauw/ParamProcessor) documentation on how to specify these.

### HookHandler

The actual behaviour for your parser hook is implemented in an implementation of HookHandler.
These implementations have a handle method which gets a Parser and a ParamProcssor\ProcessingResult,
which is supposed to return a string.

### Knitting it all together

This library also provides two additional classes, FunctionRunner, and HookRegistrant. The former
takes care of invoking the ParamProcessor library based on a HookDefinition. The later takes care
of registering the parser hooks defined by your HookDefinition objects to a MediaWiki Parser object.

```php
$awesomeHookDefinition = new HookDefinition( 'awesome', array( /* ... */ ) );
$anotherHookDefinition = new HookDefinition( 'another', array( /* ... */ ) );

$awesomeHookHandler = new AwesomeHookHandler( /* ... */ );
$anotherHookHandler = new AnotherHookHandler( /* ... */ );

$hookRegistrant = new HookRegistrant( $mediaWikiParser );

$hookRegistrant->registerFunctionHandler( $awesomeHookDefinition, $awesomeHookHandler );
$hookRegistrant->registerFunctionHandler( $anotherHookDefinition, $anotherHookHandler );
```

If you want to have the same hook, but with other default behaviour, you can avoid any kind of
duplication by doing something as follows on top of the above code:

```php
$hookRegistrant->registerFunctionHandler( $extraAwesomeHookDefinition, $awesomeHookHandler );
```

Where $extraAwesomeHookDefinition is a variation of $awesomeHookDefinition.

### Parser functions and tag hooks

To register a parser function, use HookRegistrant::registerFunctionHandler.

```php
$hookRegistrant->registerFunctionHandler( $awesomeHookDefinition, $awesomeHookHandler );
```

To register a tag hook, use HookRegistrant::registerHookHandler.

```php
$hookRegistrant->registerHookHandler( $awesomeHookDefinition, $awesomeHookHandler );
```

Both functions take the exact same arguments, so once you created a HookDefinition and
a HookHandler, you can have them registered as both parser function and tag hook with
no extra work.

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

The tests can be run for the `tests/phpunit` directory of your MediaWiki installation
with this command:

    php phpunit.php -c ../../extensions/ParserHooks/

## Authors

ParserHooks has been written by [Jeroen De Dauw](https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw)
as a hobby project to support the [SubPageList MediaWiki extension]
(https://github.com/JeroenDeDauw/SubPageList/blob/master/README.md).

## Release notes

### 1.5 (2016-03-05)

* Added license now shown on Special:Version
* Updated translations
* Made minor style improvements
* Ensured the extension works with PHP 7 and MediaWiki up to at least 1.27

### 1.4 (2014-07-05)

* Changed the PHPUnit bootstrap so that the tests can be run via the MediaWiki test runner
* Updated the CI configuration to test the code against multiple MediaWiki versions

### 1.3 (2014-06-25)

* Updated i18n message files
* Changed class loading to PSR-4
* Updated the used Validator version to 2.x >= 2.0.4

### 1.2.1 (2013-11-22)

* Updated the used Validator version from 1.0 alpha to 1.0.0.1 stable, or later

### 1.2 (2013-09-30)

* Fixed parameter handling bug in FunctionRunner
* Added system test for tag hook handling

### 1.1 (2013-09-25)

* Added HookRunner and HookRegistrant::registerHook
* Added HookRegistrant::registerFunctionHandler and HookRegistrant::registerHookHandler
* Fixed parameter handling bug in FunctionRunner
* Improved HookRegistrantTest

You can [read the release blog post](https://www.entropywins.wtf/blog/2013/09/25/parserhooks-1-1-released/)

### 1.0.1 (2013-09-22)

* Improved HookDefinition documentation
* Added extra type checking in HookDefinition
* Added extra tests for HookDefinition
* Added coveralls.io support
* Added PHPUnit file whitelisting (for more accurate and faster generated coverage reports)

### 1.0 (2013-07-14)

* Initial release ([blog post](https://www.entropywins.wtf/blog/2013/07/14/parserhooks-declarative-oop-api-for-mediawiki-released/))

## Links

* [ParserHooks on Packagist](https://packagist.org/packages/mediawiki/parser-hooks)
* [ParserHooks on Ohloh](https://www.ohloh.net/p/parserhooks)
* [ParserHooks on MediaWiki.org](https://www.mediawiki.org/wiki/Extension:ParserHooks)
* [ParserHooks on Scrutinizer CI](https://scrutinizer-ci.com/g/JeroenDeDauw/ParserHooks)
* [ParserHooks on coveralls.io](https://coveralls.io/r/wikimedia/mediawiki-extensions-ParserHooks)
* [TravisCI build status](https://travis-ci.org/JeroenDeDauw/ParserHooks)
