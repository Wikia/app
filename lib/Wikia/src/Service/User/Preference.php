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

use Wikia\Domain\User\PreferenceValue;

class Preference implements PreferenceService {

	private $gateway;

	function __construct( PreferencePersistence $gateway ) {
		$this->gateway = $gateway;
	}

	public function setPreferences( $userId, $preferences ) {
		if ( !is_array( $preferences ) || empty( $preferences ) ) {
			return false;
		}

		$this->authenticateUser( $userId );

		return $this->gateway->save( $userId, $preferences );
	}

	public function getPreferences( $userId ) {
		$this->authenticateUser( $userId );

		$result = $this->gateway->get( $userId );
		if (!is_array($result)) {
			return [];
		}

		$preferences = $this->gatewayResultToPreferenceArray( $result );

		return $preferences;
	}

	protected function authenticateUser( $userId ) {
		// Arguably this doesn't belong here. Until we have a better understanding of how this currently
		// works we should at least ensure that the service does not get a request that we know it can't
		// handle
		if ( $userId !== $this->gateway->getWikiaUserId() ) {
			throw new \Wikia\Service\GatewayUnauthorizedException( "Unauthorized to set preferences." );
		}
	}

	public function gatewayResultToPreferenceArray(array $result) {
		$preferences = [];
		foreach( $result as $index => $row ) {
			if (isset($row["name"]) && isset($row["value"])) {
				$preferences[] = new Preference($row["name"], $row["value"]);
			}
		}

		return $preferences;
	}
}
