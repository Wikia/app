<?php

namespace Wikia\Maintenance\UserGroups;

use DatabaseBase;
use Doctrine\Common\Cache\CacheProvider;
use WikiaSQL;

class UserGroupUpdater {

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
		$localUsers = $this->getLocalUserGroups($wikiId, $wikiDb);
		$this->refreshExpiredGlobalGroups(array_keys($localUsers));

		foreach ($localUsers as $userId => $localGroups) {
			$this->deleteGroups($userId, $wikiId);

			if (!empty($localGroups)) {
				$this->saveGroups($userId, $localGroups);
			}
		}
	}

	private function getLocalUserGroups($wikiId, DatabaseBase $wikiDb) {
		$allGroups = $this->groupList->getGroups();
		return (new WikiaSQL())
				->SELECT('ug_user', 'ug_group')
				->FROM('user_groups')
				->WHERE('ug_group')->IN($this->groupList->getLocalGroups())
				->runLoop($wikiDb, function(&$localUsers, $row) use ($allGroups, $wikiId) {
					if (!isset($localUsers[$row->ug_user])) {
						$localUsers[$row->ug_user] = [];
					}

					if (isset($allGroups[$row->ug_group])) {
						$localUsers[$row->ug_user][] = [$row->ug_user, $allGroups[$row->ug_group], $wikiId];
					}
				});
	}

	private function refreshExpiredGlobalGroups($userList) {
		foreach ($userList as $userId) {
			$cacheIsRecent = $this->cache->fetch($userId);
			if ($cacheIsRecent) {
				continue;
			}

			$this->refreshGlobalGroups($userId);
			$this->cache->save($userId, true, 60*60*24);
		}
	}

	private function refreshGlobalGroups($userId) {
		$allGroups = $this->groupList->getGroups();
		$userGroups = (new WikiaSQL())
				->SELECT('ug_group')
				->FROM('user_groups')
				->WHERE('ug_user')->EQUAL_TO($userId)
					->AND_('ug_group')->IN($this->groupList->getGlobalGroups())
				->runLoop($this->wikicitiesDb, function(&$userGroups, $row) use ($allGroups, $userId) {
					if (isset($allGroups[$row->ug_group])) {
						$userGroups[] = [$userId, $allGroups[$row->ug_group], self::GLOBAL_GROUP_WIKI_ID];
					}
				});

		$this->deleteGroups($userId, self::GLOBAL_GROUP_WIKI_ID);
		if (!empty($userGroups)) {
			$this->saveGroups($userId, $userGroups);
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
