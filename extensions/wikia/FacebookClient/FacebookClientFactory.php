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
	 * if creation of mapping does not succeed, returns not-OK Status
	 *
	 * @param int $wikiaUserId
	 * @param int $fbUserId
	 * @return \Status (status value will be null or \FacebookMapModel if successfully created)
	 */
	public function connectToFacebook( $wikiaUserId, $fbUserId ) {
		$status = new Status();

		try {
			$map = \FacebookMapModel::getUserMapping( $wikiaUserId, $fbUserId );
			if ( $map ) {
				// Error! There is already a mapping
				$status->setResult( false );
				$status->error( 'fbconnect-error-already-connected' );
			} else {
				$bizToken = \FacebookClient::getInstance()->getBizToken();
				$map = \FacebookMapModel::createUserMapping(
					$wikiaUserId,
					$fbUserId,
					$bizToken
				);
				if ( $map instanceof \FacebookMapModel ) {
					$status->setResult( true, $map );
				} else {
					$status->setResult( false );
					$status->error( 'fbconnect-error' );
				}
			}
		} catch ( \Exception $e ) {
			$messageParams = [];
			switch ( $e->getCode() ) {
				case \FacebookMapModel::ERROR_WIKIA_USER_ID_MISMATCH :
					$messageParams[] = 'fbconnect-error-fb-account-in-use';
					$messageParams[] = \User::whoIs( $wikiaUserId );
					break;
				case \FacebookMapModel::ERROR_FACEBOOK_USER_ID_MISMATCH :
					$messageParams[] = 'fbconnect-error-already-connected';
					break;
				default :
					$messageParams[] = 'fbconnect-error';
			}
			$status->setResult( false );
			call_user_func_array( [$status, 'error'], $messageParams );
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

	/**
	 * Get error message key and parameters from status
	 *
	 * @param \Status $status
	 * @return array of error message key, and message parameters as an array
	 * @throws Exception if called on an "OK" Status
	 */
	public function getStatusError( \Status $status ) {
		if ( $status->isOK() ) {
			throw new \Exception( 'Status contains no errors' );
		}

		$errors = $status->getErrorsByType( 'error' );
		if ( ! empty( $errors[0]['message'] ) ) {
			$message = $errors[0]['message'];
			$params = $errors[0]['params'];
		} else {
			$message = 'fbconnect-error';
			$params = [];
		}

		return [$message, $params];
	}
}
