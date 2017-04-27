<?php

namespace Wikia\UserGroups;

use Doctrine\Common\Cache\CacheProvider;

class UserGroupList {

	const CACHE_KEY = "global-groups";

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
	 * @param UserGroupStorage $storage
	 * @param CacheProvider $cache
	 */
	public function __construct(
			UserGroupStorage $storage,
			CacheProvider $cache) {

		$this->storage = $storage;
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
				$groups = $this->storage->buildGroups(array_merge($this->globalGroups, $this->localGroups));
				$this->cache->save(self::CACHE_KEY, $groups, 60*60*24);
			}

			$this->groups = $groups;
		}

		return $this->groups;
	}

	public function getGlobalGroups() {
		return array_filter(
				$this->getGroups(),
				function($groupName) {
					return $this->isGlobalGroup($groupName);
				},
				ARRAY_FILTER_USE_KEY);
	}

	public function getLocalGroups() {
		return array_filter(
				$this->getGroups(),
				function($groupName) {
					return $this->isLocalGroup($groupName);
				},
				ARRAY_FILTER_USE_KEY);
	}

	public function isLocalGroup($group) {
		return in_array($group, $this->localGroups);
	}

	public function isGlobalGroup($group) {
		return in_array($group, $this->globalGroups);
	}
}
