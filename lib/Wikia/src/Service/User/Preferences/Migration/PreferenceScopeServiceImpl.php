<?php

namespace Wikia\Service\User\Preferences\Migration;

class PreferenceScopeServiceImpl implements PreferenceScopeService {

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
	 *    Wikia\Service\User\Preferences\Migration\PreferenceScopeServiceImpl::GLOBAL_SCOPE_PREFS,
	 *    Wikia\Service\User\Preferences\Migration\PreferenceScopeServiceImpl::LOCAL_SCOPE_PREFS})
	 * @param array $globalPreferences
	 * @param array $localPreferences
	 */
	public function __construct( array $globalPreferences, array $localPreferences ) {
		$this->globalPreferenceLiterals = $globalPreferences['literals'];
		$this->globalPreferenceRegex = '/' . implode( '|', $globalPreferences['regexes'] ) . '/';
		$this->localPreferenceRegex = '/' . implode( '|', $localPreferences['regexes'] ) . '/';
	}

	public function splitLocalPreference( $option ) {
		if ( preg_match( '/(.*?)-([0-9]+)$/', $option, $matches ) && count( $matches ) == 3 ) {
			return [$matches[1], $matches[2]];
		}

		return [null, null];
	}

	public function isLocalPreference( $option ) {
		return preg_match( $this->localPreferenceRegex, $option ) > 0;
	}

	public function isGlobalPreference( $option ) {
		if ( in_array( $option, $this->globalPreferenceLiterals ) ) {
			return true;
		}

		return preg_match( $this->globalPreferenceRegex, $option ) > 0;
	}
}
