<?php

namespace Wikia\UserGroups;

use DatabaseBase;
use WikiaSQL;

class UserGroupStorage {

	const GLOBAL_GROUP_WIKI_ID = 0;
	
	/** @var DatabaseBase */
	private $specialsDb;

	/** @var DatabaseBase */
	private $wikiCitiesDb;

	/**
	 * @param DatabaseBase $specialsDb
	 * @param DatabaseBase $wikiCitiesDb
	 */
	public function __construct(
			DatabaseBase $specialsDb,
			DatabaseBase $wikiCitiesDb) {

		$this->specialsDb = $specialsDb;
		$this->wikiCitiesDb = $wikiCitiesDb;
	}

	public function findUsersWithGroup($groupName) {
		return (new WikiaSQL())
				->SELECT('user_id', 'wiki_id')
				->FROM('user_groups')
				->JOIN('groups')->ON('user_groups.group_id', 'groups.id')
				->WHERE('groups.name')->EQUAL_TO($groupName)
				->runLoop($this->specialsDb, function(&$userList, $row) {
					$userList[] = [$row->user_id, $row->wiki_id];
				});
	}

	public function findUsersWithGlobalGroups($groupName) {
		return $this->findUsersWithLocalGroup($groupName, self::GLOBAL_GROUP_WIKI_ID);
	}

	public function findUsersWithLocalGroup($groupName, $wikiIds) {
		if (!is_array($wikiIds)) {
			$wikiIds = [$wikiIds];
		}

		return (new WikiaSQL())
				->SELECT('user_id', 'wiki_id')
				->FROM('user_groups')
				->JOIN('groups')->ON('user_groups.group_id', 'groups.id')
				->WHERE('groups.name')->EQUAL_TO($groupName)
					->AND_('user_groups.wiki_id')->IN($wikiIds)
				->runLoop($this->specialsDb, function(&$userList, $row) {
					$userList[] = [$row->user_id, $row->wiki_id];
				});
	}
	
	public function syncUserGlobalGroups($groupList) {
		$this->syncUserGroups($this->wikiCitiesDb, $groupList, self::GLOBAL_GROUP_WIKI_ID);
	}
	
	public function syncUserLocalGroups($groupList, DatabaseBase $wikiDb, $wikiId) {
		$this->syncUserGroups($wikiDb, $groupList, $wikiId);
	}
	
	public function buildGroups($groupNames) {
		$groups = (new WikiaSQL())
				->SELECT('id', 'name')
				->FROM('groups')
				->WHERE('name')->IN($groupNames)
				->runLoop(
						$this->specialsDb,
						function(&$groups, $row) {
							$groups[$row->name] = $row->id;
						});

		$newGroups = array_diff($groupNames, array_keys($groups));

		foreach ($newGroups as $g) {
			(new WikiaSQL())
					->INSERT('groups')
					->SET('name', $g)
					->run($this->specialsDb);

			$groups[$g] = $this->specialsDb->insertId();
		}
		
		return $groups;
	}

	private function syncUserGroups(DatabaseBase $db, $groupList, $wikiId) {
		$groupNames = array_keys($groupList);

		$userGroups = (new WikiaSQL())
				->SELECT('ug_user', 'ug_group')
				->FROM('user_groups')
				->WHERE('ug_group')->IN($groupNames)
				->runLoop($db, function(&$userGroups, $row) use ($groupList, $wikiId) {
					if (!isset($userGroups[$row->ug_user])) {
						$userGroups[$row->ug_user] = [];
					}

					if (isset($groupList[$row->ug_group])) {
						$userGroups[$row->ug_user][] = [$row->ug_user, $groupList[$row->ug_group], $wikiId];
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
		return (new WikiaSQL())
				->DELETE('user_groups')
				->WHERE('user_id')->EQUAL_TO($userId)
				->AND_('wiki_id')->EQUAL_TO($wikiId)
				->run($this->specialsDb);
	}

	private function saveGroups($userId, $userGroups) {
		return (new WikiaSQL())
				->INSERT('user_groups', ['user_id', 'group_id', 'wiki_id'])
				->VALUES($userGroups)
				->ON_DUPLICATE_KEY_UPDATE(['user_id' => $userId])
				->run($this->specialsDb);
	}
}
