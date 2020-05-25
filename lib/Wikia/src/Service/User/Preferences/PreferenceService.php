<?php

namespace Wikia\Service\User\Preferences;

use Wikia\Domain\User\Preferences\LocalPreference;
use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Logger\Loggable;
use Wikia\Persistence\User\Preferences\PreferencePersistence;
use Wikia\Service\PersistenceException;

class PreferenceService {

	use Loggable;

	/** @var PreferencePersistence */
	private $persistence;

	/** @var UserPreferences[string] */
	private $preferences;

	/** @var string[] */
	private $hiddenPrefs;

	/** @var UserPreferences */
	private $defaultPreferences;

	/** @var UserPreferences $anonUserPreferences */
	private $anonUserPreferences;

	/** @var string[] */
	private $forceSavePrefs;

	/**
	 * @param PreferencePersistence $persistence
	 * @param UserPreferences $defaultPrefs
	 * @param string[] $hiddenPrefs preferences that fall back to the defaults, whether or not a user has them set
	 * @param string[] $forceSavePrefs
	 */
	public function __construct(
		PreferencePersistence $persistence,
		UserPreferences $defaultPrefs,
		$hiddenPrefs,
		$forceSavePrefs ) {
		$this->persistence = $persistence;
		$this->hiddenPrefs = $hiddenPrefs;
		$this->defaultPreferences = $defaultPrefs;
		$this->forceSavePrefs = $forceSavePrefs;
		$this->preferences = [];

		// SUS-5236: anonymous users will always have default preferences
		$this->anonUserPreferences = clone $defaultPrefs;
	}

	public function getPreferences( $userId ) {
		return $this->load( $userId );
	}

	/**
	 * forcefully overwrite preferences. this should only be used when correcting errors during migration!
	 * @param $userId
	 * @param UserPreferences $preferences
	 */
	public function setPreferences( $userId, UserPreferences $preferences ) {
		$this->preferences[$userId] = $preferences;
	}

	public function getGlobalPreference( $userId, $name, $default = null, $ignoreHidden = false ) {
		if ( in_array( $name, $this->hiddenPrefs ) && !$ignoreHidden ) {
			return $this->getGlobalDefault( $name );
		}

		$preferences = $this->load( $userId );
		if ( $preferences->hasGlobalPreference( $name ) ) {
			return $preferences->getGlobalPreference( $name );
		}

		return $default;
	}

	public function setGlobalPreference( $userId, $name, $value ) {
		if ( $value === null ) {
			$value = $this->getGlobalDefault( $name );
		}

		$this->load( $userId )->setGlobalPreference( $name, $value );
	}

	public function deleteGlobalPreference( $userId, $name ) {
		$this->load( $userId )->deleteGlobalPreference( $name );
	}

	public function getLocalPreference( $userId, $wikiId, $name, $default = null, $ignoreHidden = false ) {
		if ( in_array( $name, $this->hiddenPrefs ) && !$ignoreHidden ) {
			return $this->getLocalDefault($name, $wikiId );
		}

		$preferences = $this->load( $userId );
		if ( $preferences->hasLocalPreference( $name, $wikiId ) ) {
			return $preferences->getLocalPreference( $name, $wikiId );
		}

		return $default;
	}

	public function setLocalPreference( $userId, $wikiId, $name, $value ) {
		if ( $value === null ) {
			$value = $this->getLocalDefault($name, $wikiId );
		}

		$this->load( $userId )->setLocalPreference( $name, $wikiId, $value );
	}

	public function deleteLocalPreference( $userId, $name, $wikiId ) {
		$this->load( $userId )->deleteLocalPreference( $name, $wikiId );
	}

	public function deleteAllPreferences( $userId ) {
		// if the preferences are marked as read-only DO NOT allow
		// purging. this is to ensure we don't make a mistake after a failed read
		if ( $this->load( $userId )->isReadOnly() ) {
			return false;
		}

		try {
			$deleted = $this->persistence->deleteAll( $userId );
			if ( $deleted ) {
				unset( $this->preferences[$userId] );
			}

			return $deleted;
		} catch (\Exception $e) {
			$this->error( $e->getMessage(), ['userId' => $userId ] );
			throw $e;
		}
	}

	public function findWikisWithLocalPreferenceValue( $preferenceName, $value ) {
		try {
			return $this->persistence->findWikisWithLocalPreferenceValue( $preferenceName, $value );
		} catch (\Exception $e) {
			$this->error( $e->getMessage(), [
				'preferenceName' => $preferenceName,
				'value' => $value, ] );
			throw $e;
		}
	}

	public function findUsersWithGlobalPreferenceValue($preferenceName, $value = null, $limit = 1000, $user_id_continue = null ) {
		try {
			return $this->persistence->findUsersWithGlobalPreferenceValue( $preferenceName, $value, $limit, $user_id_continue );
		} catch (\Exception $e) {
			$this->error( $e->getMessage(), [
				'preferenceName' => $preferenceName,
				'value' => $value,
				'limit' => $limit,
				'afterUserId' => $user_id_continue] );
			throw $e;
		}
	}


	/**
	 * @param string $userId
	 * @return bool
	 * @throws \Exception
	 */
	public function save( $userId ) {
		if ( $userId == 0 ) {
			return false;
		}

		$prefs = $this->load( $userId );

		// if the UserPreferences have been marked as read-only they should NOT be saved
		if ( $prefs->isReadOnly() ) {
			return false;
		}

		$prefsToSave = new UserPreferences();

		foreach ( $prefs->getGlobalPreferences() as $pref ) {
			if ( $this->prefIsSaveable( $pref->getName(), $pref->getValue(), $this->getGlobalDefault( $pref->getName() ) ) ) {
				$prefsToSave->setGlobalPreference( $pref->getName(), $pref->getValue() );
			}
		}

		foreach ( $prefs->getLocalPreferences() as $wikiId => $wikiPreferences ) {
			foreach ( $wikiPreferences as $pref ) {
				/** @var $pref LocalPreference */
				if ( $this->prefIsSaveable( $pref->getName(), $pref->getValue(), $this->getLocalDefault( $pref->getName(), $wikiId ) ) ) {
					$prefsToSave->setLocalPreference( $pref->getName(), $pref->getWikiId(), $pref->getValue() );
				}
			}
		}

		if ( !$prefsToSave->isEmpty() ) {
			try {
				return $this->persistence->save( $userId, $prefsToSave );
			} catch ( \Exception $e ) {
				$this->error( $e->getMessage(), ['userId' => $userId ] );
				throw $e;
			}
		}

		return true;
	}

	public function getGlobalDefault( $pref ) {
		return $this->defaultPreferences->getGlobalPreference( $pref );
	}

	public function getLocalDefault( $pref, $wikiId ) {
		return $this->defaultPreferences->getLocalPreference( $pref, $wikiId );
	}

	protected function getLoggerContext() {
		return ['class' => 'PreferenceService'];
	}

	/**
	 * @param $userId
	 * @return UserPreferences
	 * @throws \Exception
	 */
	private function load( $userId ) {

		if ( empty( $userId ) ) {
			return $this->anonUserPreferences;
		}

		if ( !isset( $this->preferences[$userId] ) ) {
			try {
				$preferences = $this->persistence->get( $userId );
			} catch ( PersistenceException $e ) {
				$this->error( $e->getMessage() . ": setting preferences in read-only mode",
					['user' => $userId] );
				$preferences = ( new UserPreferences() )
					->setReadOnly( true );
			} catch ( \Exception $e ) {
				$this->error( $e->getMessage(), ['userId' => $userId] );
				throw $e;
			}

			$this->preferences[$userId] = $this->applyDefaults( $preferences );
		}

		return $this->preferences[$userId];
	}

	private function applyDefaults( UserPreferences $preferences ) {
		foreach ( $this->defaultPreferences->getGlobalPreferences() as $globalPreference ) {
			if ( !$preferences->hasGlobalPreference( $globalPreference->getName() ) ) {
				$preferences->setGlobalPreference( $globalPreference->getName(), $globalPreference->getValue() );
			}
		}

		foreach ( $this->defaultPreferences->getLocalPreferences() as $wikiId => $localPreferences ) {
			foreach ( $localPreferences as $localPreference ) {
				/** @var LocalPreference $localPreference */
				if ( !$preferences->hasLocalPreference( $localPreference->getName(), $wikiId ) ) {
					$preferences->setLocalPreference( $localPreference->getName(), $wikiId, $localPreference->getValue() );
				}
			}
		}

		return $preferences;
	}

	private function prefIsSaveable( $pref, $value, $valueFromDefaults ) {
		return in_array( $pref, $this->forceSavePrefs ) || $value != $valueFromDefaults ||
			( $valueFromDefaults === null && $value !== false && $value !== null );
	}
}
