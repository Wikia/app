<?php

namespace Wikia\Service\User\Preferences;

use Wikia\Domain\User\Preference;
use Wikia\Util\Optional\Optional;

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

	/**
	 * @Inject({
	 *    Wikia\Service\User\Preferences\PreferenceService::class,
	 *    Wikia\Service\User\Preferences\UserPreferences::HIDDEN_PREFS,
	 *    Wikia\Service\User\Preferences\UserPreferences::DEFAULT_PREFERENCES})
	 * @param PreferenceService $preferenceService
	 * @param string[] $hiddenPrefs
	 * @param string[string] $defaultPrefs
	 */
	public function __construct(PreferenceService $preferenceService, $hiddenPrefs, $defaultPrefs) {
		$this->service = $preferenceService;
		$this->hiddenPrefs = $hiddenPrefs;
		$this->defaultPreferences = $defaultPrefs;
		$this->preferences = [];
	}

	public function getPreferences($userId) {
		return $this->load($userId);
	}

	public function setPreferencesInCache($userId, $preferences) {
		$this->preferences[$userId] = $this->defaultPreferences;

		foreach ($preferences as $key => $val) {
			$this->preferences[$userId][$key] = $val;
		}
	}

	public function get($userId, $pref, $default = null, $ignoreHidden = false) {
		$preferences = $this->load($userId);

		if (in_array($pref, $this->hiddenPrefs) && !$ignoreHidden) {
			return $this->getFromDefault($pref)->orElse($default);
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
			if ( $val === null && $default->isPresent() ) {
				$val = $default->get();
			}
			$this->preferences[ $userId ][ $pref ] = $val;
			$prefToSave[ ] = new Preference( $pref, $val );
		}

		$this->save( $userId, $prefToSave );
	}

	/**
	 * @param $pref
	 * @return Optional
	 */
	public function getFromDefault($pref) {
		if (isset($this->defaultPreferences[$pref])) {
			return Optional::ofNullable($this->defaultPreferences[$pref]);
		}

		return Optional::emptyOptional();
	}

	private function load($userId) {
		if (!isset($this->preferences[$userId])) {
			$this->preferences[$userId] = $this->defaultPreferences;
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
		if ($userId == 0) {
			return;
		}

		if (!empty($prefs)) {
			$this->service->setPreferences($userId, $prefs);
		}
	}
}
