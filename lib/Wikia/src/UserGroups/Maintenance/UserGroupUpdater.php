<?php

namespace Wikia\UserGroups\Maintenance;

use DatabaseBase;
use Doctrine\Common\Cache\CacheProvider;
use Wikia\UserGroups\UserGroupList;
use Wikia\UserGroups\UserGroupStorage;

class UserGroupUpdater {

	const GLOBAL_GROUPS_CACHE_KEY = "global-groups";

	/** @var UserGroupStorage */
	private $storage;
	
	/** @var UserGroupList */
	private $groupList;

	/** @var CacheProvider */
	private $cache;

	/**
	 * @param UserGroupStorage $storage
	 * @param UserGroupList $groupList
	 * @param CacheProvider $cache
	 */
	public function __construct(
			UserGroupStorage $storage,
			UserGroupList $groupList,
			CacheProvider $cache) {
		
		$this->storage = $storage;
		$this->groupList = $groupList;
		$this->cache = $cache;
	}
	
	public function updateForWiki($wikiId, DatabaseBase $wikiDb) {
		$this->refreshGlobalGroups();
		$this->storage->syncUserLocalGroups($this->groupList->getLocalGroups(), $wikiDb, $wikiId);
	}

	private function refreshGlobalGroups() {
		$recentlyPopulated = $this->cache->fetch(self::GLOBAL_GROUPS_CACHE_KEY);

		if ($recentlyPopulated) {
			return;
		}

		$this->storage->syncUserGlobalGroups($this->groupList->getGlobalGroups());
		$this->cache->save(self::GLOBAL_GROUPS_CACHE_KEY, true, 60*60*24);
	}
}
