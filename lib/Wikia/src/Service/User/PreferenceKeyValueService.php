<?php
/**
 *
 * User preference service.
 * Assumptions:
 *	- The user exists (persisted in the database) and we have a valid user id.
 *	- Only the currently logged in user as set in the gateway WikiaUserId is
 *	  able to change their preferences
 *
 * Open questions:
 *	- How do we handle the preference white list on this side? Do we?
 *	- How do we standardize on a set of exceptions that will cross the libraries we use?
 *	  Things that could go wrong:
 *	  - gateway error e.g. 500 with API or database exception locally
 *	  - request error e.g. 400
 *	  - user not found 404
 *	  - unauthorized
 *	  - success 200
 *
 */
namespace Wikia\Service\User;

use Wikia\Domain\User\Preference;

class PreferenceKeyValueService implements PreferenceService {

	private $persistenceAdapter;

	function __construct( PreferencePersistence $persistenceAdapter ) {
		$this->persistenceAdapter = $persistenceAdapter;
	}

	public function setPreferences( $userId, array $preferences ) {
		if ( !is_array( $preferences ) || empty( $preferences ) ) {
			return false;
		}

		return $this->persistenceAdapter->save( $userId, $preferences );
	}

	public function getPreferences( $userId ) {
		$preferences = $this->persistenceAdapter->get( $userId );
		if (!is_array($preferences)) {
			return [];
		}

		$filtered = array_filter($preferences, function($v, $k) {
			return ($v instanceof Preference);
		}, ARRAY_FILTER_USE_BOTH);

		if (count($filtered) != count($preferences)) {
			 throw new \UnexpectedValueException("Error, expected all \"Preference\" objects.");
		}

		return $preferences;
	}
}
