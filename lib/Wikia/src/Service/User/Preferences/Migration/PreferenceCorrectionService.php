<?php

namespace Wikia\Service\User\Preferences\Migration;

use Wikia\Domain\User\Preferences\LocalPreference;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Logger\Loggable;
use Wikia\Service\User\Preferences\PreferenceService;

class PreferenceCorrectionService {

	use Loggable;

	const PREFERENCE_CORRECTION_ENABLED = "preference_correction_enabled";

	/** @var bool */
	private $correctionEnabled;

	/** @var PreferenceScopeService */
	private $scopeService;

	/** @var PreferenceService */
	private $preferenceService;

	/**
	 * @Inject({
	 *    Wikia\Service\User\Preferences\PreferenceService::class,
	 *    Wikia\Service\User\Preferences\Migration\PreferenceScopeService::class,
	 *    Wikia\Service\User\Preferences\Migration\PreferenceCorrectionService::PREFERENCE_CORRECTION_ENABLED})
	 * @param PreferenceService $preferenceService
	 * @param PreferenceScopeService $scopeService
	 * @param bool $correctionEnabled
	 */
	public function __construct( PreferenceService $preferenceService, PreferenceScopeService $scopeService, $correctionEnabled ) {
		$this->scopeService = $scopeService;
		$this->preferenceService = $preferenceService;
		$this->correctionEnabled = $correctionEnabled;
	}

	public function compareAndCorrect( $userId, $userOptions ) {
		if ( !$this->correctionEnabled ) {
			return 0;
		}

		$actual = $this->preferenceService->getPreferences( $userId );
		list( $differences, $expected ) = $this->compare( $actual, $userId, $userOptions );

		if ( $differences != 0 ) {
			$this->info(
				'correcting preferences',
				[
					'num_differences' => $differences,
					'user_id' => $userId] );
			$this->preferenceService->setPreferences( $userId, $expected );
			$this->preferenceService->save( $userId );
		}

		return $differences;
	}

	private function compare( UserPreferences $actualPreferences, $userId, $options ) {
		$expectedPreferences = new UserPreferences();
		$differences = 0;

		foreach ( $options as $name => $value ) {
			if ( $this->scopeService->isGlobalPreference( $name ) ) {
				$expectedPreferences->setGlobalPreference( $name, $value );

				if ( !$actualPreferences->hasGlobalPreference( $name ) ||
					$actualPreferences->getGlobalPreference( $name ) !== $value ) {

					$this->logMissingPreference( $userId, $name, $value, $actualPreferences->getGlobalPreference( $name ) );
					++$differences;
				}
			} elseif ( $this->scopeService->isLocalPreference( $name ) ) {
				list( $prefName, $wikiId ) = $this->scopeService->splitLocalPreference( $name );

				if ( !$prefName || !$wikiId ) {
					$this->warning( "unable to split local preference", ['option' => $name] );
					continue;
				}

				$expectedPreferences->setLocalPreference( $prefName, $wikiId, $value );

				if ( !$actualPreferences->hasLocalPreference( $prefName, $wikiId ) ||
					$actualPreferences->getLocalPreference( $prefName, $wikiId ) !== $value ) {

					$this->logMissingPreference( $userId, $name, $value, $actualPreferences->getLocalPreference( $prefName, $wikiId ) );
					++$differences;
				}
			}
		}

		foreach ($actualPreferences->getGlobalPreferences() as $globalPreference) {
			if (!isset($options[$globalPreference->getName()])) {
				$this->logExtraPreference($userId, $globalPreference->getName(), $globalPreference->getValue());
				++$differences;
			}
		}

		foreach ($actualPreferences->getLocalPreferences() as $wikiId => $localPreferences) {
			foreach ($localPreferences as $localPreference) {
				/** @var LocalPreference $localPreference */
				$optionName = $localPreference->getName().'-'.$wikiId;
				if (!isset($options[$optionName])) {
					$this->logExtraPreference($userId, $optionName, $localPreference->getValue());
					++$differences;
				}
			}
		}

		return [$differences, $expectedPreferences];
	}

	protected function getLoggerContext() {
		return ['class' => 'PreferenceCorrectionService'];
	}

	private function logMissingPreference( $userId, $name, $expected, $actual ) {
		$this->warning( 'preference mismatch', [
			'userId' => $userId,
			'preference' => $name,
			'type' => 'missing_preference',
			'expected' => $expected,
			'actual' => $actual, ] );
	}

	private function logExtraPreference($userId, $name, $value) {
		$this->warning('preference mismatch', [
			'userId' => $userId,
			'preference' => $name,
			'type' => 'extra_preference',
			'expected' => '<missing>',
			'actual' => $value,]);
	}
}
