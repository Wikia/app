# Callback container

[![Build Status](https://secure.travis-ci.org/onoi/callback-container.svg?branch=master)](http://travis-ci.org/onoi/callback-container)
[![Code Coverage](https://scrutinizer-ci.com/g/onoi/callback-container/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/onoi/callback-container/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/onoi/callback-container/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/onoi/callback-container/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/onoi/callback-container/version.png)](https://packagist.org/packages/onoi/callback-container)
[![Packagist download count](https://poser.pugx.org/onoi/callback-container/d/total.png)](https://packagist.org/packages/onoi/callback-container)
[![Dependency Status](https://www.versioneye.com/php/onoi:callback-container/badge.png)](https://www.versioneye.com/php/onoi:callback-container)

A simple container loader for lazy initialization of registered callback handlers. Part of the
code base has been extracted from [Semantic MediaWiki][smw] and is now being deployed as independent library.

## Requirements

PHP 5.3 / HHVM 3.5 or later

## Installation

The recommended installation method for this library is to add
the dependency to your [composer.json][composer].

```json
{
	"require": {
		"onoi/callback-container": "~1.0"
	}
}
```

## Usage

```php
class FooCallbackContainer implements CallbackContainer {

	public function register( CallbackLoader $callbackLoader ) {
		$this->addCallbackHandlers( $callbackLoader);
	}

	private function addCallbackHandlers( $callbackLoader ) {

		$callbackLoader->registerCallback( 'Foo', function( array $input ) {
			$stdClass = new \stdClass;
			$stdClass->input = $input;

			return $stdClass;
		} );

		$callbackLoader->registerExpectedReturnType( 'Foo', '\stdClass' );
	}
}
```
```php
$deferredCallbackLoader = new DeferredCallbackLoader();

$deferredCallbackLoader->registerCallbackContainer( new FooCallbackContainer() );
$instance = $deferredCallbackLoader->load( 'Foo', array( 'a', 'b' ) );
$instance = $deferredCallbackLoader->singleton( 'Foo', array( 'aa', 'bb' ) );
```

If a callback handler is registered with an expected return type then any
mismatch of a returning instance will throw a `RuntimeException`.

## Contribution and support

If you want to contribute work to the project please subscribe to the
developers mailing list and have a look at the [contribution guidelinee](/CONTRIBUTING.md). A list
of people who have made contributions in the past can be found [here][contributors].

* [File an issue](https://github.com/onoi/callback-container/issues)
* [Submit a pull request](https://github.com/onoi/callback-container/pulls)

### Tests

The library provides unit tests that covers the core-functionality normally run by the
[continues integration platform][travis]. Tests can also be executed manually using the
`composer phpunit` command from the root directory.

## Release notes

- 1.0.0 Initial release (2015-09-08)
 - Added the `CallbackContainer` and `CallbackLoader` interface
 - Added the `DeferredCallbackLoader` and `NullCallbackLoader` implementation

## License

[GNU General Public License 2.0 or later][license].

[composer]: https://getcomposer.org/
[contributors]: https://github.com/onoi/callback-container/graphs/contributors
[license]: https://www.gnu.org/copyleft/gpl.html
[travis]: https://travis-ci.org/onoi/callback-container
[smw]: https://github.com/SemanticMediaWiki/SemanticMediaWiki/
