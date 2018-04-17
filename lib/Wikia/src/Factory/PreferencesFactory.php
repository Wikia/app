<?php
namespace Wikia\Factory;

use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Service\User\Preferences\Migration\PreferenceScopeService;
use Wikia\Service\User\Preferences\PreferenceService;

class PreferencesFactory extends AbstractFactory {
	/** @var PreferenceScopeService $scopeService */
	private $scopeService;

	/** @var PreferenceService $preferenceService */
	private $preferenceService;
	
	public function setPreferenceService( PreferenceService $preferenceService ) {
		$this->preferenceService = $preferenceService;
	}

	public function scopeService(): PreferenceScopeService {
		if ( $this->scopeService === null ) {
			global $wgGlobalUserPreferenceWhiteList, $wgLocalUserPreferenceWhiteList;
			$this->scopeService = new PreferenceScopeService(
				$wgGlobalUserPreferenceWhiteList, $wgLocalUserPreferenceWhiteList
			);
		}

		return $this->scopeService;
	}

	private function defaultPreferences(): UserPreferences {
		$defaultOptions = \User::getDefaultOptions();
		$defaultPreferences = new UserPreferences();

		$scopeService = $this->scopeService();

		foreach ( $defaultOptions as $name => $val ) {
			if ( $scopeService->isGlobalPreference( $name ) ) {
				$defaultPreferences->setGlobalPreference( $name, $val );
			} elseif ( $scopeService->isLocalPreference( $name ) ) {
				list( $prefName, $wikiId ) = $scopeService->splitLocalPreference( $name );
				$defaultPreferences->setLocalPreference( $prefName, $wikiId, $val );
			}
		}

		return $defaultPreferences;
	}

	public function preferenceService(): PreferenceService {
		global $wgHiddenPrefs;

		if ( $this->preferenceService === null ) {
			$apiProvider = $this->serviceFactory()->providerFactory()->apiProvider();
			$persistence = new PreferencePersistence( $apiProvider );

			$defaultPreferences = $this->defaultPreferences();

			$this->preferenceService = new PreferenceService( $persistence, $defaultPreferences, $wgHiddenPrefs, [ 'language' ] );
		}

		return $this->preferenceService;
	}
}
