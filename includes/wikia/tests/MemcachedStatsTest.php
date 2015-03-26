<?php

use Wikia\Memcached\MemcachedStats;

class MemcachedStatsTest extends WikiaBaseTest {

	const WIKI_PREFIX = 'wiki123';

	public function setUp() {
		parent::setUp();

		// mock wfWikiID() to return the faked prefix
		$this->mockGlobalFunction('wfWikiID', self::WIKI_PREFIX);
	}

	/**
	 * @param string $key
	 * @param string $expected
	 * @dataProvider normalizeKeyDataProvider
	 */
	public function testNormalizeKey($key, $expected) {
		$this->assertEquals($expected, MemcachedStats::normalizeKey($key));
	}

	public function normalizeKeyDataProvider() {
		return [
			[
				'key' => self::WIKI_PREFIX . ':user:id:119245',
				'expected' => '*:user:id:*'
			],
			[
				'key' => self::WIKI_PREFIX . ':linkcache:good:6e5bd2fbb1845c64534e8c6840ef73f3',
				'expected' => '*:linkcache:good:*'
			],
			[
				'key' => self::WIKI_PREFIX . ':imageserving-images-data:1727:100:100',
				'expected' => '*:imageserving-images-data:*:*:*'
			],
			[
				'key' => self::WIKI_PREFIX . ':timeago:i18n:pl:3',
				'expected' => '*:timeago:i18n:pl:*'
			],
			[
				'key' => self::WIKI_PREFIX . ':favicon-v1',
				'expected' => '*:favicon-v1'
			],
			[
				'key' => self::WIKI_PREFIX . ':VoteHelper:VoteHelper::getUserCacheKey:123:0:84.77.150.66:VER1',
				'expected' => '*:VoteHelper:VoteHelper::getUserCacheKey:*:*:*:VER1'
			],
			// shared keys
			[
				'key' => 'wikifactory:wikia:v1:1031256',
				'expected' => 'wikifactory:wikia:v1:*'
			],
			[
				'key' => 'extuser:119245:c6',
				'expected' => 'extuser:*:*'
			],
			[
				'key' => 'wikicities_c6:sharedLinks:1686:21e74e1deae71d1903d7a323d4eae53e',
				'expected' => 'wikicities_c6:sharedLinks:*:*'
			],
			[
				'key' => 'wikicities:WikiFactoryHub::getCategoryId:1031256',
				'expected' => 'wikicities:WikiFactoryHub::getCategoryId:*'
			],
		];
	}
}