# Semantic Scribunto

[![Build Status](https://secure.travis-ci.org/SemanticMediaWiki/SemanticScribunto.svg?branch=master)](http://travis-ci.org/SemanticMediaWiki/SemanticScribunto)
[![Code Coverage](https://scrutinizer-ci.com/g/SemanticMediaWiki/SemanticScribunto/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/SemanticMediaWiki/SemanticScribunto/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/SemanticMediaWiki/SemanticScribunto/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/SemanticMediaWiki/SemanticScribunto/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/mediawiki/semantic-scribunto/version.png)](https://packagist.org/packages/mediawiki/semantic-scribunto)
[![Packagist download count](https://poser.pugx.org/mediawiki/semantic-scribunto/d/total.png)](https://packagist.org/packages/mediawiki/semantic-scribunto)
[![Dependency Status](https://www.versioneye.com/php/mediawiki:semantic-scribunto/badge.png)](https://www.versioneye.com/php/mediawiki:semantic-scribunto)

Semantic Scribunto (a.k.a. SSC) is a [Semantic Mediawiki][smw] extension to provide native support for the
[Scribunto][scri] extension.

## Requirements

- PHP 5.5 or later
- MediaWiki 1.26 or later
- [Semantic MediaWiki][smw] 2.3 or later

## Installation

The recommended way to install Semantic Scribunto is by using [Composer][composer] with:

```json
{
	"require": {
		"mediawiki/semantic-scribunto": "~1.0"
	}
}
```
1. From your MediaWiki installation directory, execute
   `composer require mediawiki/semantic-scribunto:~1.0`
2. Navigate to _Special:Version_ on your wiki and verify that the package
   have been successfully installed.

## Usage

A description of the `mw.smw` library functions can be found [here](docs/README.md).

## Contribution and support

If you want to contribute work to the project please subscribe to the developers mailing list and
have a look at the contribution guideline.

* [File an issue](https://github.com/SemanticMediaWiki/SemanticScribunto/issues)
* [Submit a pull request](https://github.com/SemanticMediaWiki/SemanticScribunto/pulls)
* Ask a question on [the mailing list](https://semantic-mediawiki.org/wiki/Mailing_list)
* Ask a question on the #semantic-mediawiki IRC channel on Freenode.

## Tests

This extension provides unit and integration tests that are run by a [continues integration platform][travis]
but can also be executed using the `composer phpunit` command from the extension base directory that will
run all tests. In order to run only a specific test suit, the following commands are provided for convenience:

- `composer unit` to run all unit tests
- `composer integration` to run all integration tests (which requires an active MediaWiki, DB connection)

## License

[GNU General Public License, version 2 or later][gpl-licence].

[smw]: https://github.com/SemanticMediaWiki/SemanticMediaWiki
[contributors]: https://github.com/SemanticMediaWiki/SemanticScribunto/graphs/contributors
[travis]: https://travis-ci.org/SemanticMediaWiki/SemanticScribunto
[gpl-licence]: https://www.gnu.org/copyleft/gpl.html
[composer]: https://getcomposer.org/
[scri]: https://www.mediawiki.org/wiki/Extension:Scribunto
