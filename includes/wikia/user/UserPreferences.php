<?php

use Wikia\Service\User\PreferenceService;
use Wikia\Domain\User\Preference;

class UserPreferences {
	const HIDDEN_PREFS = "user_preferences_hidden_prefs";
	const DEFAULT_PREFERENCES = "user_preferences_default_prefs";
	const FORCE_SAVE_PREFERENCES = "user_preferences_force_save_prefs";

	/** @var PreferenceService */
	private $service;

	/** @var string[string][string] */
	private $preferences;

	/** @var string[] */
	private $hiddenPrefs;

	/** @var string[string] */
	private $defaultPreferences;

	/** @var string[] */
	private $forceSavePrefs;

	/**
	 * @Inject({
	 *    Wikia\Service\User\PreferenceService::class,
	 *    UserPreferences::HIDDEN_PREFS,
	 *    UserPreferences::DEFAULT_PREFERENCES,
	 *    UserPreferences::FORCE_SAVE_PREFERENCES})
	 * @param PreferenceService $preferenceService
	 * @param string[] $hiddenPrefs
	 * @param string[string] $defaultPrefs
	 * @param string[] $forceSavePrefs
	 */
	public function __construct(PreferenceService $preferenceService, $hiddenPrefs, $defaultPrefs, $forceSavePrefs) {
		$this->service = $preferenceService;
		$this->hiddenPrefs = $hiddenPrefs;
		$this->defaultPreferences = $defaultPrefs;
		$this->forceSavePrefs = $forceSavePrefs;
		$this->preferences = [];
	}

	public function getPreferences($userId) {
		return $this->load($userId);
	}

	public function setPreferences($userId, $preferences) {
		$this->preferences[$userId] = $preferences;
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
	 * @param string $pref
	 * @param string $val
	 */
	public function set($userId, $pref, $val) {
		$this->load($userId);

		if ($val == null && isset($this->defaultPreferences[$pref])) {
			$val = $this->defaultPreferences[$pref];
		}

		$this->preferences[$pref] = $val;
		$this->save($userId, [new Preference($pref, $val)]);
	}

	public function getFromDefault($pref) {
		if (isset($this->defaultPreferences[$pref])) {
			return $this->defaultPreferences[$pref];
		}

		return null;
	}

	private function load($userId) {
		if (!isset($this->preferences[$userId])) {
			$this->preferences[$userId] = [];
			foreach ($this->service->getPreferences($userId) as $pref) {
				$this->preferences[$userId][$pref->getName()] = $pref->getValue();
			};
		}

		return $this->preferences[$userId];
	}

	/**
	 * @param string $userId
	 * @param Preference[] $prefs
	 */
	private function save($userId, $prefs) {
		$prefsToSave = [];

		foreach ($prefs as $p) {
			if ($this->prefIsSaveable($p->getName(), $p->getValue())) {
				$prefsToSave[] = $p;
			}
		}

		if (!empty($prefsToSave)) {
			$this->service->setPreferences($userId, $prefsToSave);
		}
	}

	private function prefIsSaveable($pref, $value) {
		$default = $this->getFromDefault($pref);

		return in_array($pref, $this->forceSavePrefs) || $value != $default ||
			($default != null && $value !== false && $value !== null);
	}
}
