<?php

/**
 * Class FacebookClientFactory
 *
 * This is a factory for retrieval of Wikia users' Facebook data
 * It is built on top of FacebookMapModel
 */
class FacebookClientFactory {

	/**
	 * Map an existing Wikia user to a Facebook id
	 * If an exact or partial match of the map already exists, OR
	 * if creation of mapping does not succeed, returns a Message object containing error
	 *
	 * @param int $wikiaUserId
	 * @param int $fbUserId
	 * @return \Status (status value will be null or \FacebookMapModel if successfully created)
	 */
	public function connectToFacebook( $wikiaUserId, $fbUserId ) {
		$status = new Status();

		try {
			$map = \FacebookMapModel::getUserMapping( $wikiaUserId, $fbUserId );
			if ( !$map ) {
				$map = \FacebookMapModel::createUserMapping( $wikiaUserId, $fbUserId );
				if ( $map instanceof \FacebookMapModel ) {
					$status->setResult( true, $map );
				} else {
					$status->setResult( false );
					$status->error( 'fbconnect-error' );
				}
			} else {
				$status->setResult( false );
				$status->error( 'fbconnect-error-already-connected' );
			}
		} catch ( \Exception $e ) {
			$messageParams = [];
			switch ( $e->getCode() ) {
				case \FacebookMapModel::ERROR_WIKIA_USER_ID_MISMATCH :
					$errorMessageKey = 'fbconnect-error-fb-account-in-use';
					$messageParams[] = \User::whoIs( $wikiaUserId );
					break;
				case \FacebookMapModel::ERROR_FACEBOOK_USER_ID_MISMATCH :
					$errorMessageKey = 'fbconnect-error-already-connected';
					break;
				default :
					$errorMessageKey = 'fbconnect-error';
			}
			$status->setResult( false );
			$status->error( $errorMessageKey, $messageParams );
		}

		return $status;
	}

	/**
	 * Determine if Facebook account with given Id is connected to a Wikia account
	 *
	 * @param int $facebookId
	 * @return bool
	 */
	public function isFacebookIdInUse( $facebookId ) {
		return (\FacebookMapModel::lookupFromFacebookID( $facebookId ) !== null);
	}
}
