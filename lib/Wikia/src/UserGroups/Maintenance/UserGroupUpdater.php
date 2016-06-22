<?php

namespace Wikia\UserGroups\Maintenance;

use DatabaseBase;
use Doctrine\Common\Cache\CacheProvider;
use Wikia\UserGroups\UserGroupList;
use WikiaSQL;

class UserGroupUpdater {

	const GLOBAL_GROUPS_CACHE_KEY = "global-groups";

	const GLOBAL_GROUP_WIKI_ID = 0;

	/** @var UserGroupList */
	private $groupList;

	/** @var DatabaseBase */
	private $specialsDb;

	/** @var DatabaseBase */
	private $wikicitiesDb;

	/** @var CacheProvider */
	private $cache;

	/**
	 * UserGroupUpdater constructor.
	 * @param UserGroupList $groupList
	 * @param DatabaseBase $specialsDb
	 * @param DatabaseBase $wikicitiesDb
	 * @param CacheProvider $cache
	 */
	public function __construct(
			UserGroupList $groupList,
			DatabaseBase $specialsDb,
			DatabaseBase $wikicitiesDb,
			CacheProvider $cache) {
		
		$this->groupList = $groupList;
		$this->specialsDb = $specialsDb;
		$this->wikicitiesDb = $wikicitiesDb;
		$this->cache = $cache;
	}
	
	public function updateForWiki($wikiId, DatabaseBase $wikiDb) {
		$this->refreshGlobalGroups();
		$this->rebuildUserGroups($wikiDb, $this->groupList->getLocalGroups(), $wikiId);
	}

	private function refreshGlobalGroups() {
		$recentlyPopulated = $this->cache->fetch(self::GLOBAL_GROUPS_CACHE_KEY);

		if ($recentlyPopulated) {
			return;
		}

		$this->rebuildUserGroups($this->wikicitiesDb, $this->groupList->getGlobalGroups(), self::GLOBAL_GROUP_WIKI_ID);
		$this->cache->save(self::GLOBAL_GROUPS_CACHE_KEY, true, 60*60*24);
	}

	private function rebuildUserGroups(DatabaseBase $db, $groupList, $wikiId) {
		$allGroups = $this->groupList->getGroups();

		$userGroups = (new WikiaSQL())
				->SELECT('ug_user', 'ug_group')
				->FROM('user_groups')
				->WHERE('ug_group')->IN($groupList)
				->runLoop($db, function(&$userGroups, $row) use ($allGroups, $wikiId) {
					if (!isset($userGroups[$row->ug_user])) {
						$userGroups[$row->ug_user] = [];
					}

					if (isset($allGroups[$row->ug_group])) {
						$userGroups[$row->ug_user][] = [$row->ug_user, $allGroups[$row->ug_group], $wikiId];
					}
				});

		foreach ($userGroups as $userId => $groups) {
			$this->deleteGroups($userId, $wikiId);
			if (!empty($groups)) {
				$this->saveGroups($userId, $groups);
			}
		}
	}

	private function deleteGroups($userId, $wikiId) {
		(new WikiaSQL())
			->DELETE('user_groups')
			->WHERE('user_id')->EQUAL_TO($userId)
				->AND_('wiki_id')->EQUAL_TO($wikiId)
			->run($this->specialsDb);
	}

	private function saveGroups($userId, $userGroups) {
		(new WikiaSQL())
				->INSERT('user_groups', ['user_id', 'group_id', 'wiki_id'])
				->VALUES($userGroups)
				->ON_DUPLICATE_KEY_UPDATE(['user_id' => $userId])
				->run($this->specialsDb);
	}
}
