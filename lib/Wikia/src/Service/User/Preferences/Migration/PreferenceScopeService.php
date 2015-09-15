<?php

namespace Wikia\Service\User\Preferences\Migration;

class PreferenceScopeService {

	const GLOBAL_SCOPE_PREFS = 'global_scope_preferences';
	const LOCAL_SCOPE_PREFS = 'local_scope_preferences';

	/** @var array */
	private $globalPreferenceLiterals = [];

	/** @var string */
	private $globalPreferenceRegex;

	/** @var string */
	private $localPreferenceRegex;

	/**
	 * @Inject({
	 *    Wikia\Service\User\Preferences\Migration\PreferenceScopeService::GLOBAL_SCOPE_PREFS,
	 *    Wikia\Service\User\Preferences\Migration\PreferenceScopeService::LOCAL_SCOPE_PREFS})
	 * @param array $globalPreferences
	 * @param array $localPreferences
	 */
	public function __construct( array $globalPreferences, array $localPreferences ) {
		if (isset($globalPreferences['literals'])) {
			$this->globalPreferenceLiterals = $globalPreferences['literals'];
		}

		if (isset($globalPreferences['regexes']) && count($globalPreferences['regexes']) > 0) {
			$this->globalPreferenceRegex = '/' . implode( '|', $globalPreferences['regexes'] ) . '/';
		}

		if (isset($localPreferences['regexes']) && count($localPreferences['regexes']) > 0) {
			$this->localPreferenceRegex = '/' . implode( '|', $localPreferences['regexes'] ) . '/';
		}
	}

	public function splitLocalPreference( $option ) {
		if ( preg_match( '/(.*?)-([0-9]+)$/', $option, $matches ) && count( $matches ) == 3 ) {
			return [$matches[1], $matches[2]];
		}

		return [null, null];
	}

	public function isLocalPreference( $option ) {
		return !empty($this->localPreferenceRegex) && preg_match( $this->localPreferenceRegex, $option ) > 0;
	}

	public function isGlobalPreference( $option ) {
		if ( in_array( $option, $this->globalPreferenceLiterals ) ) {
			return true;
		}

		return !empty($this->globalPreferenceRegex) && preg_match( $this->globalPreferenceRegex, $option ) > 0;
	}
}
