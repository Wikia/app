<?php

namespace Wikia\Persistence\User\Preferences;

use Swagger\Client\ApiException;
use Swagger\Client\User\Preferences\Api\UserPreferencesApi;
use Swagger\Client\User\Preferences\Models\GlobalPreference as SwaggerGlobalPref;
use Swagger\Client\User\Preferences\Models\LocalPreference as SwaggerLocalPref;
use Swagger\Client\User\Preferences\Models\UserPreferences as SwaggerUserPreferences;
use Wikia\Domain\User\Preferences\LocalPreference;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Service\NotFoundException;
use Wikia\Service\PersistenceException;
use Wikia\Service\Swagger\ApiProvider;
use Wikia\Service\UnauthorizedException;
use Wikia\Util\AssertionException;
use Wikia\Util\WikiaProfiler;

/**
 * @Injectable(lazy=true)
 */
class PreferencePersistenceSwaggerService implements PreferencePersistence {

	use WikiaProfiler;

	const SERVICE_NAME = "user-preference";

	/** @var ApiProvider */
	private $apiProvider;

	public function __construct( ApiProvider $apiProvider ) {
		$this->apiProvider = $apiProvider;
	}

	/**
	 * @param int $userId
	 * @param UserPreferences $preferences
	 * @return true success, false or exception otherwise
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function save( $userId, UserPreferences $preferences ) {
		$globalPrefs = $localPrefs = [];

		foreach ( $preferences->getGlobalPreferences() as $globalPref ) {
			$globalPrefs[] = ( new SwaggerGlobalPref() )
				->setName( $globalPref->getName() )
				->setValue( $globalPref->getValue() );
		}

		foreach ( $preferences->getLocalPreferences() as $wikiPreferences ) {
			foreach ( $wikiPreferences as $wikiPreference ) {
				/** @var $wikiPreference LocalPreference */
				$localPrefs[] = ( new SwaggerLocalPref() )
					->setWikiId( $wikiPreference->getWikiId() )
					->setName( $wikiPreference->getName() )
					->setValue( $wikiPreference->getValue() );
			}
		}

		$userPreferences = ( new SwaggerUserPreferences() )
			->setLocalPreferences( $localPrefs )
			->setGlobalPreferences( $globalPrefs );

		try {
			$this->savePreferences( $this->getApi( $userId ), $userId, $userPreferences );
			return true;
		} catch ( ApiException $e ) {
			$this->handleApiException( $e );
			return false;
		}
	}

	/**
	 * Get the users preferences.
	 *
	 * @param int $userId
	 * @return UserPreferences
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 */
	public function get( $userId ) {
		$prefs = new UserPreferences();

		try {
			$storedPreferences = $this->getPreferences( $this->getApi( $userId ), $userId );
			$globalPreferences = $storedPreferences->getGlobalPreferences();
			$localPreferences = $storedPreferences->getLocalPreferences();

			if ( $globalPreferences != null ) {
				foreach ( $globalPreferences as $p ) {
					$prefs->setGlobalPreference( $p->getName(), $p->getValue() );
				}
			}

			if ( $localPreferences != null ) {
				foreach ( $localPreferences as $p ) {
					$prefs->setLocalPreference( $p->getName(), $p->getWikiId(), $p->getValue() );
				}
			}
		} catch ( ApiException $e ) {
			$this->handleApiException( $e );
		} catch ( AssertionException $e ) {
			throw new PersistenceException( "unable to load preferences: " . $e->getMessage() );
		}

		return $prefs;
	}

	/**
	 * @param $userId
	 * @return UserPreferencesApi
	 */
	private function getApi( $userId ) {
		$profilerStart = $this->startProfile();
		$api = $this->apiProvider->getAuthenticatedApi( self::SERVICE_NAME, $userId, UserPreferencesApi::class );
		$this->endProfile(
			\Transaction::EVENT_USER_PREFERENCES,
			$profilerStart,
			[
				'user_id' => $userId,
				'method' => 'getApi', ] );

		return $api;
	}

	private function savePreferences( UserPreferencesApi $api, $userId, SwaggerUserPreferences $userPreferences ) {
		$profilerStart = $this->startProfile();
		$api->setUserPreferences( $userId, $userPreferences );
		$this->endProfile(
			\Transaction::EVENT_USER_PREFERENCES,
			$profilerStart,
			[
				'user_id' => $userId,
				'method' => 'setPreferences', ] );
	}

	private function getPreferences( UserPreferencesApi $api, $userId ) {
		$profilerStart = $this->startProfile();
		$preferences = $api->getUserPreferences( $userId );
		$this->endProfile(
			\Transaction::EVENT_USER_PREFERENCES,
			$profilerStart,
			[
				'user_id' => $userId,
				'method' => 'getPreferences', ] );

		return $preferences;
	}

	/**
	 * @param ApiException $e
	 * @throws UnauthorizedException
	 * @throws NotFoundException
	 * @throws PersistenceException
	 */
	private function handleApiException( ApiException $e ) {
		switch ( $e->getCode() ) {
			case UnauthorizedException::CODE:
				throw new UnauthorizedException();
				break;
			case NotFoundException::CODE:
				break;
			default:
				throw new PersistenceException( $e->getMessage() );
				break;
		}
	}
}
