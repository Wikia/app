<?php

/**
 * Class FacebookClientService
 *
 * This is a service for retrieval and modifications to Wikia users' Facebook data
 * It is built on top of FacebookMapModel
 */
class FacebookClientService {

	/**
	 * Map an existing Wikia user to a Facebook id
	 * If an exact or partial match of the map already exists, OR
	 * if creation of mapping does not succeed, returns a Message object containing error
	 *
	 * @param int $wikiaUserId
	 * @param int $fbUserId
	 * @return \FacebookMapModel|\Message
	 */
	public function connectToFacebook( $wikiaUserId, $fbUserId ) {
		$map = \FacebookMapModel::lookupUserMapping( $wikiaUserId, $fbUserId );
		if ( $map == null ) {
			$map = \FacebookMapModel::createUserMapping( $wikiaUserId, $fbUserId );
			if ( $map instanceof \FacebookMapModel ) {
				return $map;
			}
		}

		$messageParams = [];
		if ( $map instanceof \FacebookMapModel ) {
			$errorMessageKey = 'fbconnect-error-already-connected';
		} else {
			switch ( $map ) {
				case \FacebookMapModel::ERROR_WIKIA_USER_ID_MISMATCH :
					$errorMessageKey = 'fbconnect-error-fb-account-in-use';
					$messageParams[] = $wikiaUserId;
					break;
				case \FacebookMapModel::ERROR_FACEBOOK_USER_ID_MISMATCH :
					$errorMessageKey = 'fbconnect-error-already-connected';
					break;
				default :
					$errorMessageKey = 'fbconnect-error';
			}
		}
		return new \Message( $errorMessageKey, $messageParams );
	}

}
