<?php

namespace Wikia\UserGroups;

use DatabaseBase;
use Doctrine\Common\Cache\CacheProvider;
use WikiaSQL;

class UserGroupList {

	const CACHE_KEY = "global-groups";

	const CACHE_TTL = 60*60*24;

	/** @var DatabaseBase */
	private $specialsDb;

	/** @var CacheProvider */
	private $cache;

	/** @var string[] */
	private $groups;

	private $globalGroups = [
		'authenticated',
		'council',
		'helper',
		'staff',
		'util',
		'vanguard',
		'voldev',
		'vstf',
		'wikiastars',
	];

	private $localGroups = [
		'bot',
		'bureaucrat',
		'chatmoderator',
		'content-moderator',
		'rollback',
		'sysop',
		'threadmoderator',
	];

	/**
	 * GlobalGroups constructor.
	 * @param DatabaseBase $specialsDb
	 * @param CacheProvider $cache
	 */
	public function __construct(
			DatabaseBase $specialsDb,
			CacheProvider $cache) {

		$this->specialsDb = $specialsDb;
		$this->cache = $cache;
		$this->groups = null;
	}

	/**
	 * ensure that groups exist in the db, and return them
	 * @return string[]
	 */
	public function getGroups() {
		if ($this->groups == null) {
			$groups = $this->cache->fetch(self::CACHE_KEY);

			if (!$groups) {
				$allGroups = array_merge($this->globalGroups, $this->localGroups);

				$groups = (new WikiaSQL())
						->SELECT('id', 'name')
						->FROM('groups')
						->WHERE('name')->IN($allGroups)
						->runLoop(
								$this->specialsDb,
								function(&$groups, $row) {
									$groups[$row->name] = $row->id;
								});

				$newGroups = array_diff($allGroups, array_keys($groups));

				foreach ($newGroups as $g) {
					(new WikiaSQL())
							->INSERT('groups')
							->SET('name', $g)
							->run($this->specialsDb);

					$groups[$g] = $this->specialsDb->insertId();
				}

				$this->cache->save(self::CACHE_KEY, $groups, self::CACHE_TTL);
			}

			$this->groups = $groups;
		}


		return $this->groups;
	}

	public function getGlobalGroups() {
		return $this->globalGroups;
	}

	public function getLocalGroups() {
		return $this->localGroups;
	}

	public function isLocalGroup($group) {
		return in_array($group, $this->localGroups);
	}

	public function isGlobalGroup($group) {
		return in_array($group, $this->globalGroups);
	}
}
