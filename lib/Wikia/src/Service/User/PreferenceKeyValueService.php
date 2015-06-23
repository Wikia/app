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

	private $gateway;

	function __construct( PreferencePersistence $gateway ) {
		$this->gateway = $gateway;
	}

	public function setPreferences( $userId, $preferences ) {
		if ( !is_array( $preferences ) || empty( $preferences ) ) {
			return false;
		}

		return $this->gateway->save( $userId, $preferences );
	}

	public function getPreferences( $userId ) {
		$result = $this->gateway->get( $userId );
		if (!is_array($result)) {
			return [];
		}

		$preferences = $this->gatewayResultToPreferenceArray( $result );

		return $preferences;
	}

	public function gatewayResultToPreferenceArray(array $result) {
		$preferences = [];
		foreach( $result as $index => $row ) {
			if (isset($row["name"]) && isset($row["value"])) {
				$preferences[] = new PreferenceKeyValueService($row["name"], $row["value"]);
			}
		}

		return $preferences;
	}
}
