<?php

use Wikia\Memcached\MemcachedStats;

/**
 * @group MemcachedStats
 */
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
				'expected' => '*:imageserving:images:data:*:*:*'
			],
			[
				'key' => self::WIKI_PREFIX . ':timeago:i18n:pl:3',
				'expected' => '*:timeago:i18n:pl:*'
			],
			[
				'key' => self::WIKI_PREFIX . ':favicon-v1',
				'expected' => '*:favicon:*'
			],
			[
				'key' => self::WIKI_PREFIX . ':VoteHelper:VoteHelper::getUserCacheKey:123:0:84.77.150.66:VER1',
				'expected' => '*:VoteHelper:VoteHelper::getUserCacheKey:*:*:*:VER1'
			],
			[
				'key' => self::WIKI_PREFIX . ':pcache:idhash:8262-0!*!0!!*!2!zh!*',
				'expected' => '*:pcache:idhash:*'
			],
			// shared keys
			[
				'key' => 'wikifactory:wikia:v1:1031256',
				'expected' => 'wikifactory:wikia:*:*'
			],
			[
				'key' => 'extuser:119245:c6',
				'expected' => 'extuser:*:*'
			],
			[
				'key' => 'wikicities_c6:sharedLinks:1686:21e74e1deae71d1903d7a323d4eae53e',
				'expected' => 'wikicities:*:sharedLinks:*:*'
			],
			[
				'key' => 'wikicities:WikiFactoryHub::getCategoryId:1031256',
				'expected' => 'wikicities:WikiFactoryHub::getCategoryId:*'
			],
			[
				'key' => 'wikifactory:domains:by_domain_hash:zombiesrun.wikia.com',
				'expected' => 'wikifactory:domains:by_domain_hash:*'
			],
			[
				'key' => 'wikicities:wikifactory:variables:metadata:v5:name:wgExtraNamespacesLocal',
				'expected' => 'wikicities:wikifactory:variables:metadata:*'
			],
			[
				'key' => 'wikicities:WallNotificationsOwner:997076_26295802v11',
				'expected' => 'wikicities:WallNotificationsOwner:*:*'
			],
			[
				'key' => 'wikicities:WallNotificationEntity:v32:100260_15217:notification',
				'expected' => 'wikicities:WallNotificationEntity:*:*:*:notification'
			],
			[
				'key' => 'wikicities:MemcacheSyncLock:wikicities:WallNotifications:1234:1164405v31',
				'expected' => 'wikicities:MemcacheSyncLock:wikicities:WallNotifications:*:*'
			],
			[
				'key' => 'AssetsManagerSassBuilder-minified-ff5434c76b952082c64416c7bd05417a',
				'expected' => 'AssetsManagerSassBuilder:minified:*'
			],
			[
				'key' => 'WikiaApiQueryAllUsers::getUsersForGroup-vstf-902227',
				'expected' => 'WikiaApiQueryAllUsers::getUsersForGroup:vstf:*'
			],
			[
				'key' => 'wikia:talk_messages:1234:ViniSD',
				'expected' => 'wikia:talk_messages:*'
			],
			[
				'key' => 'wikicities:InterwikiDispatcher::isWikiExists:es.mario',
				'expected' => 'wikicities:InterwikiDispatcher::isWikiExists:*'
			],
			[
				'key' => 'wikicities:UserCache:Zephyr135',
				'expected' => 'wikicities:UserCache:*'
			],
			[
				'key' => 'wikicities:datamart:1234:wam:374799-withDate',
				'expected' => 'wikicities:datamart:*:wam:*:withDate'
			],
			[
				'key' => 'wikicities:filepage:globalusage:etspikri:123',
				'expected' => 'wikicities:filepage:globalusage:*'
			],
		];
	}
}
