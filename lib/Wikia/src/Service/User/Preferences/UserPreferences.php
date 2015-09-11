<?php

namespace Wikia\Service\User\Preferences;

use Wikia\Cache\Memcache\Memcache;
use Wikia\Domain\User\GlobalPreference;
use Wikia\Domain\User\Preferences;
use Wikia\Logger\Loggable;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Util\WikiaProfiler;

class UserPreferences {

	use WikiaProfiler;
	use Loggable;

	const HIDDEN_PREFS = "user_preferences_hidden_prefs";
	const DEFAULT_PREFERENCES = "user_preferences_default_prefs";
	const FORCE_SAVE_PREFERENCES = "user_preferences_force_save_prefs";
	const PROFILE_EVENT = \Transaction::EVENT_USER_PREFERENCES;
	const CACHE_VERSION = 1;

	/** @var Memcache */
	private $cache;

	/** @var PreferencePersistence */
	private $persistence;

	/** @var Preferences[string] */
	private $preferences;

	/** @var string[] */
	private $hiddenPrefs;

	/** @var string[] */
	private $defaultPreferences;

	/** @var string[] */
	private $forceSavePrefs;

	/**
	 * @Inject({
	 *    Wikia\Cache\Memcache\Memcache::class,
	 *    Wikia\Service\User\Preferences\PreferencePersistence::class,
	 *    Wikia\Service\User\Preferences\UserPreferences::HIDDEN_PREFS,
	 *    Wikia\Service\User\Preferences\UserPreferences::DEFAULT_PREFERENCES,
	 *    Wikia\Service\User\Preferences\UserPreferences::FORCE_SAVE_PREFERENCES})
	 * @param Memcache $cache,
	 * @param PreferencePersistence $persistence
	 * @param string[] $hiddenPrefs
	 * @param string[string] $defaultPrefs
	 * @param string[] $forceSavePrefs
	 */
	public function __construct(
		Memcache $cache,
		PreferencePersistence $persistence,
		$hiddenPrefs,
		$defaultPrefs,
		$forceSavePrefs) {

		$this->cache = $cache;
		$this->persistence = $persistence;
		$this->hiddenPrefs = $hiddenPrefs;
		$this->defaultPreferences = $defaultPrefs;
		$this->forceSavePrefs = $forceSavePrefs;
		$this->preferences = [];
	}

	public function getPreferences($userId) {
		return $this->load($userId);
	}

	public function loadFromCache($userId) {
		$preferences = $this->cache->get($this->getCacheKey($userId));

		if (!$preferences) {
			$preferences = new Preferences();
			foreach ($this->defaultPreferences as $name => $val) {
				$preferences->setGlobalPreference(new GlobalPreference($name, $val));
			}
		}
	}

	public function saveToCache($userId) {
		$cacheKey = $this->getCacheKey($userId);
		return $this->cache->set($cacheKey, $this->preferences[$userId]);
	}

	public function deleteFromCache($userId) {
		return $this->cache->delete($this->getCacheKey($userId));
	}

	public function getCacheKey($userId) {
		return get_class($this).":$userId:".self::CACHE_VERSION;
	}

	public function setPreferencesInCache($userId, $preferences) {
		$this->preferences[$userId] = $this->defaultPreferences;

		foreach ($preferences as $key => $val) {
			$this->preferences[$userId][$key] = $val;
		}
	}

	public function getLocalPreference($userId, $wikiId, $default = null, $ignoreHidden = false) {

	}

	public function setLocalPreference($userId, $wikiId, $name, $value) {

	}

	public function getGlobalPreference($userId, $name, $default = null, $ignoreHidden = false) {

	}

	public function setGlobalPreference($userId, $name, $value) {

	}

	public function get($userId, $pref, $default = null, $ignoreHidden = false) {
		$preferences = $this->load($userId);

		if (in_array($pref, $this->hiddenPrefs) && !$ignoreHidden) {
			return $this->getFromDefault($pref);
		} elseif (!array_key_exists($pref, $preferences)) {
			return $default;
		}

		return $preferences[$pref];
	}

	/**
	 * @param int $userId
	 * @param string $pref
	 * @param string $val
	 */
	public function set( $userId, $pref, $val ) {
		$this->setMultiple( $userId, [ $pref => $val ] );
	}

	/**
	 * @param int $userId
	 * @param array $prefs
	 */
	public function setMultiple( $userId, $prefs ) {
		$currentPreferences = $this->load( $userId );
		$prefToSave = [ ];

		foreach ( $prefs as $pref => $val ) {
			if ($currentPreferences[$pref] == $val) {
				continue;
			}

			$default = $this->getFromDefault( $pref );
			if ( $val === null && isset( $default ) ) {
				$val = $default;
			}
			$this->preferences[ $userId ][ $pref ] = $val;
			$prefToSave[ ] = new GlobalPreference( $pref, $val );
		}

		$this->save( $userId, $prefToSave );
	}

	public function getFromDefault($pref) {
		if (isset($this->defaultPreferences[$pref])) {
			return $this->defaultPreferences[$pref];
		}

		return null;
	}

	private function load($userId) {
		if (!isset($this->preferences[$userId])) {
			$this->preferences[$userId] = $this->defaultPreferences;
			foreach ($this->persistence->getPreferences($userId) as $pref) {
				$this->preferences[$userId][$pref->getName()] = $pref->getValue();
			};
		}

		return $this->preferences[$userId];
	}

	/**
	 * @param string $userId
	 * @param GlobalPreference[] $prefs
	 */
	private function save($userId, $prefs) {
		if ($userId == 0) {
			return;
		}

		$prefsToSave = [];

		foreach ($prefs as $p) {
			if ($this->prefIsSaveable($p->getName(), $p->getValue())) {
				$prefsToSave[] = $p;
			}
		}

		if (!empty($prefsToSave)) {
			$this->persistence->setPreferences($userId, $prefsToSave);
		}
	}

	private function prefIsSaveable($pref, $value) {
		$default = $this->getFromDefault($pref);

		return in_array($pref, $this->forceSavePrefs) || $value != $default ||
			($default != null && $value !== false && $value !== null);
	}
}
