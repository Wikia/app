<?php

namespace Onoi\Cache\Tests\Integration;

use HashBagOStuff;
use Onoi\Cache\MediaWikiCache;

/**
 * @group onoi-cache
 *
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class MediaWikiCacheIntegrationTest extends CacheIntegrationTestCase {

	protected $cache;

	protected function setUp() {

		if ( !class_exists( '\HashBagOStuff' ) ) {
			$this->markTestSkipped( 'HashBagOStuff is not available' );
		}

		$this->cache = new MediaWikiCache( new HashBagOStuff() );
	}

}
