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

class PreferenceService implements PreferenceServiceInterface {

	private $gateway;

	function __construct( PreferenceGatewayInterface $gateway ) {
		$this->gateway = $gateway;
	}

	public function setPreferences( $userId, $preferences ) {
		if ( !is_array( $preferences ) || empty( $preferences ) ) {
			return false;
		}

		if ( $userId !== $this->gateway->getWikiaUserId() ) {
			throw new \Wikia\Service\GatewayUnauthorizedException( "Unauthorized to set preferences." );
		}

		return $this->gateway->save( $userId, $preferences );
	}

	public function getPreferences( $userId ) {

	}
}
