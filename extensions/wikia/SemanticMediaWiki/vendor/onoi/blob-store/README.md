# Blob store

[![Build Status](https://secure.travis-ci.org/onoi/blob-store.svg?branch=master)](http://travis-ci.org/onoi/blob-store)
[![Code Coverage](https://scrutinizer-ci.com/g/onoi/blob-store/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/onoi/blob-store/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/onoi/blob-store/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/onoi/blob-store/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/onoi/blob-store/version.png)](https://packagist.org/packages/onoi/blob-store)
[![Packagist download count](https://poser.pugx.org/onoi/blob-store/d/total.png)](https://packagist.org/packages/onoi/blob-store)
[![Dependency Status](https://www.versioneye.com/php/onoi:blob-store/badge.png)](https://www.versioneye.com/php/onoi:blob-store)

A simple interface to manage schema-free temporal persistent key/values. This was part of
the [Semantic MediaWiki][smw] code base and is now being deployed as independent library.

It is suggested to use either redis, riak, or mongodb as back-end provider depending on the
use case.

## Requirements

- PHP 5.3 or later
- Onoi/Cache ~1.1

## Installation

The recommended installation method for this library is by either adding
the dependency to your [composer.json][composer].

```json
{
	"require": {
		"onoi/blob-store": "~1.1"
	}
}
```

## Usage

```php
class Foo {

	private $blobStore;

	public function __construct( BlobStore $blobStore ) {
		$this->blobStore = $blobStore;
	}

	public function doSomethingFor( $id ) {
		$container = $this->blobStore->read( md5( $id ) );

		$container->set( 'one', array( new \stdClass, 'Text' ) );

		$container->append(
			'one',
			new \stdClass
		);

		$container->delete( 'two' );

		$this->blobStore->save( $container );
	}
}
```
```php
$cacheFactory = new CacheFactory();

$compositeCache = $cacheFactory->newCompositeCache( array(
	$cacheFactory->newFixedInMemoryLruCache(),
	$cacheFactory->newDoctrineCache( new \Doctrine\Common\Cache\RedisCache( ... ) )
) );

or

$compositeCache = $cacheFactory->newCompositeCache( array(
	$cacheFactory->newFixedInMemoryLruCache(),
	$cacheFactory->newMediaWikiCache( \ObjectCache::getInstance( 'redis' ) )
) );

$blobStore = new BlobStore( 'foo', $compositeCache );

$instance = new Foo( $blobStore );
$instance->doSomethingFor( 'bar' );
```

When creating an instance a namespace is required to specify the context of the
storage in case the `BlobStore` is used for different use cases.

## Contribution and support

If you want to contribute work to the project please subscribe to the
developers mailing list and have a look at the [contribution guidelinee](/CONTRIBUTING.md). A list of people who have made contributions in the past can be found [here][contributors].

* [File an issue](https://github.com/onoi/blob-store/issues)
* [Submit a pull request](https://github.com/onoi/blob-store/pulls)

### Tests

The library provides unit tests that covers the core-functionality normally run by the [continues integration platform][travis]. Tests can also be executed manually using the `composer phpunit` command from the root directory.

### Release notes

* 1.1.0 (2015-06-13)
 - Removed tracking of internal ID list
 - Added `Container::setExpiryInSeconds`

* 1.0.0 (2015-06-02)
 - Initial release

## License

[GNU General Public License 2.0 or later][license].

[composer]: https://getcomposer.org/
[contributors]: https://github.com/onoi/blob-store/graphs/contributors
[license]: https://www.gnu.org/copyleft/gpl.html
[travis]: https://travis-ci.org/onoi/blob-store
[smw]: https://github.com/SemanticMediaWiki/SemanticMediaWiki/
