# Message reporter

[![Build Status](https://secure.travis-ci.org/onoi/message-reporter.svg?branch=master)](http://travis-ci.org/onoi/message-reporter)
[![Code Coverage](https://scrutinizer-ci.com/g/onoi/message-reporter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/onoi/message-reporter/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/onoi/message-reporter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/onoi/message-reporter/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/onoi/message-reporter/version.png)](https://packagist.org/packages/onoi/message-reporter)
[![Packagist download count](https://poser.pugx.org/onoi/message-reporter/d/total.png)](https://packagist.org/packages/onoi/message-reporter)
[![Dependency Status](https://www.versioneye.com/php/onoi:message-reporter/badge.png)](https://www.versioneye.com/php/onoi:message-reporter)

An interface to report and relay arbitrary messages to registered handlers. This was part of
the [Semantic MediaWiki][smw] code base and is now being deployed as independent library.

## Requirements

PHP 5.3 or later

## Installation

The recommended installation method for this library is by either adding
the dependency to your [composer.json][composer].

```json
{
	"require": {
		"onoi/message-reporter": "~1.0"
	}
}
```
or to execute `composer require onoi/message-reporter:~1.0`.

## Usage

The message reporter specifies `Onoi\MessageReporter\MessageReporter` as an interface for all interactions with a set of supporting classes:
- `MessageReporterFactory`
- `ObservableMessageReporter`
- `NullMessageReporter`

```php
	class Bar {

		private $reporter;

		public function __construct() {
			$this->reporter = MessageReporterFactory::getInstance()->newNullMessageReporter();
		}

		public function setMessageReporter( MessageReporter $reporter ) {
			$this->reporter = $reporter;
		}

		public function doSomethingElse() {
			$this->reporter->reportMessage( 'Did something ...' );
		}
	}
```
```php
	class Foo implements MessageReporter {

		public function doSomething( Bar $bar ) {

			$messageReporterFactory = new MessageReporterFactory();

			$messageReporter = $messageReporterFactory->newObservableMessageReporter();
			$messageReporter->registerReporterCallback( array( $this, 'reportMessage' ) );

			or

			// If the class implements the MessageReporter
			$messageReporter->registerMessageReporter( $this );

			$bar->setMessageReporter( $messageReporter );
			$bar->doSomethingElse();
		}

		public function reportMessage( $message ) {
			// output
		}
	}

	$foo = new Foo();
	$foo->doSomething( new Bar() );
```

## Contribution and support

If you want to contribute work to the project please subscribe to the
developers mailing list and have a look at the [contribution guidelinee](/CONTRIBUTING.md). A list of people who have made contributions in the past can be found [here][contributors].

* [File an issue](https://github.com/onoi/message-reporter/issues)
* [Submit a pull request](https://github.com/onoi/message-reporter/pulls)

### Tests

The library provides unit tests that covers the core-functionality normally run by the [continues integration platform][travis]. Tests can also be executed manually using the PHPUnit configuration file found in the root directory.

### Release notes

* 1.0.0 initial release (2015-01-24)

## License

[GNU General Public License 2.0 or later][license].

[composer]: https://getcomposer.org/
[contributors]: https://github.com/onoi/message-reporter/graphs/contributors
[license]: https://www.gnu.org/copyleft/gpl.html
[travis]: https://travis-ci.org/onoi/message-reporter
[smw]: https://github.com/SemanticMediaWiki/SemanticMediaWiki/
