<?php

namespace Wikia\Service\User\Preferences;

use Wikia\Cache\Memcache\Memcache;
use Wikia\Domain\User\LocalPreference;
use Wikia\Domain\User\Preferences;
use Wikia\Logger\Loggable;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Util\WikiaProfiler;

class PreferenceService {

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
	 *    Wikia\Persistence\User\Preferences\PreferencePersistence::class,
	 *    Wikia\Service\User\Preferences\PreferenceService::HIDDEN_PREFS,
	 *    Wikia\Service\User\Preferences\PreferenceService::DEFAULT_PREFERENCES,
	 *    Wikia\Service\User\Preferences\PreferenceService::FORCE_SAVE_PREFERENCES})
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
		}

		$this->preferences[$userId] = $this->applyDefaults($preferences);
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

	public function getGlobalPreference($userId, $name, $default = null, $ignoreHidden = false) {
		if (in_array($name, $this->hiddenPrefs) && !$ignoreHidden) {
			return $this->getFromDefault($name);
		}

		$preferences = $this->load($userId);
		if ($preferences->hasGlobalPreference($name)) {
			return $preferences->getGlobalPreference($name);
		}

		return $default;
	}

	public function setGlobalPreference($userId, $name, $value) {
		$this->load($userId)->setGlobalPreference($name, $value);
	}

	public function getLocalPreference($userId, $wikiId, $name, $default = null, $ignoreHidden = false) {
		if (in_array($name, $this->hiddenPrefs) && !$ignoreHidden) {
			return $this->getFromDefault($name);
		}

		$preferences = $this->load($userId);
		if ($preferences->hasLocalPreference($name, $wikiId)) {
			return $preferences->getLocalPreference($name, $wikiId);
		}

		return $default;
	}

	public function setLocalPreference($userId, $wikiId, $name, $value) {
		$this->load($userId)->setLocalPreference($name, $wikiId, $value);
	}

	/**
	 * @param string $userId
	 * @return bool
	 * @throws \Exception
	 */
	public function save($userId) {
		$prefs = $this->load($userId);
		$prefsToSave = new Preferences();

		foreach ($prefs->getGlobalPreferences() as $pref) {
			if ($this->prefIsSaveable($pref->getName(), $pref->getValue())) {
				$prefsToSave->setGlobalPreference($pref->getName(), $pref->getValue());
			}
		}

		foreach ($prefs->getLocalPreferences() as $wikiId => $wikiPreferences) {
			foreach ($wikiPreferences as $pref) {
				/** @var $pref LocalPreference */
				if ($this->prefIsSaveable($pref->getName(), $pref->getValue())) {
					$prefsToSave->setLocalPreference($pref->getName(), $pref->getWikiId(), $pref->getValue());
				}
			}
		}

		if (!$prefsToSave->isEmpty()) {
			try {
				$profilerStart = $this->startProfile();
				$result = $this->persistence->save($userId, $prefsToSave);
				$this->endProfile(
					self::PROFILE_EVENT,
					$profilerStart,
					[
						'user_id' => $userId,
						'method' => 'setPreferences',]);
				return $result;
			} catch (\Exception $e) {
				$this->error($e->getMessage(), ['user' => $userId]);
				throw $e;
			}
		}

		return true;
	}

	public function getFromDefault($pref) {
		if (isset($this->defaultPreferences[$pref])) {
			return $this->defaultPreferences[$pref];
		}

		return null;
	}

	/**
	 * @param $userId
	 * @return Preferences
	 * @throws \Exception
	 */
	private function load($userId) {
		if ($userId == 0) {
			return [];
		} elseif (!isset($this->preferences[$userId])) {
			try {
				$profilerStart = $this->startProfile();
				$preferences = $this->persistence->get($userId);
				$this->endProfile(
					self::PROFILE_EVENT,
					$profilerStart,
					[
						'user_id' => $userId,
						'method' => 'getPreferences',]);
			} catch (\Exception $e) {
				$this->error($e->getMessage(), ['user' => $userId]);
				throw $e;
			}

			$this->preferences[$userId] = $this->applyDefaults($preferences);
		}

		return $this->preferences[$userId];
	}

	private function applyDefaults(Preferences $preferences) {
		foreach ($this->defaultPreferences as $name => $val) {
			if (!$preferences->hasGlobalPreference($name)) {
				$preferences->setGlobalPreference($name, $val);
			}
		}

		return $preferences;
	}

	private function prefIsSaveable($pref, $value) {
		$default = $this->getFromDefault($pref);

		if ($value == $default) {
			return false;
		}

		return in_array($pref, $this->forceSavePrefs) || $value != $default ||
			($default != null && $value !== false && $value !== null);
	}
}
