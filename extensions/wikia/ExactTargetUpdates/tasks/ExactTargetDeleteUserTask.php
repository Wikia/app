<?php
use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetDeleteUserTask {

	/**
	 * Task for removing user data in ExactTarget
	 * @param int $iUserId Id of user to be deleted
	 */
	public function deleteUserData( $iUserId ) {
		$this->deleteSubscriber( $iUserId );
		$this->deleteUser( $iUserId );
		$this->deleteUserProperties( $iUserId );
	}

	/**
	 * Deletes Subscriber object in ExactTarget by API request if email is not used by other user
	 * @param int $iUserId
	 */
	public function deleteSubscriber( $iUserId ) {
		$sEmail = $this->getUserEmail( $iUserId );
		if ( !$this->isEmailInUse( $sEmail, $iUserId ) ) {
			$this->doDeleteSubscriber( $sEmail );
		}
	}

	/**
	 * Sends delete request to actually delete Subscriber object in ExactTarget by API request
	 * @param string $sUserEmail
	 */
	private function doDeleteSubscriber( $sUserEmail ) {
		$oSubscriber = new ExactTarget_Subscriber();
		$oSubscriber->SubscriberKey = $sUserEmail;
		$this->performDelete( [ $oSubscriber ], 'Subscriber' );
	}

	/**
	 * Deletes DataExtension object in ExactTarget by API request
	 * that reflects Wikia entry from user table
	 * @param int $iUserId
	 */
	public function deleteUser( $iUserId ) {
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserDeleteParams( $iUserId );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->deleteRequest( $aApiParams );
	}

	/**
	 * Deletes DataExtension objects in ExactTarget by API request
	 * that reflects Wikia entry from user_properties table
	 * @param int $iUserId
	 */
	public function deleteUserPropertiesData( $iUserId ) {
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserPropertiesDeleteParams( $iUserId );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->deleteRequest( $aApiParams );
	}

	/**
	 * Retrieves user email from ExactTarget based on provided user ID
	 * @param int $iUserId
	 * @return null|string
	 */
	public function getUserEmail( $iUserId ) {
		$oSimpleFilterPart = $this->wrapSimpleFilterPart( 'user_id', $iUserId );
		$oRetrieveRequest = $this->wrapRetrieveRequest( 'user', [ 'user_email' ], $oSimpleFilterPart );
		$oRetrieveRequestMessage = $this->wrapRetrieveRequestMessage( $oRetrieveRequest );

		$oEmailResult = $oClient->Retrieve( $oRetrieveRequestMessage );
		if ( isset( $oEmailResult->Results->Properties->Property->Value ) ) {
			return $oEmailResult->Results->Properties->Property->Value;
		}

		$this->notice( __METHOD__ . ' user DataExtension object not found for user_id = ' . $iUserId );
		return null;
	}

	/**
	 * Checks whether there are any users that has provided email
	 * @param string $sEmail Email address to check in ExactTarget
	 * @param int $iSkipUserId Skip this user ID when checking if email is used by any account
	 * @return bool
	 */
	public function isEmailInUse( $sEmail, $iSkipUserId = null ) {
		/* @var stdClass $oResults */
		$oUsersIds = $this->retrieveUserIdsByEmail( $sEmail );
		$iUsersCount = count( $oUsersIds->Results );

		// Email is in use when there are more than one user with email
		$ret = ( $iUsersCount > 1 );

		// One or less users
		if ( !$ret ) {
			// Email is in use when there's one user not equal to $iSkipUserId from parameters list
			$ret = $iUsersCount == 1 && $oUsersIds->Results->Properties->Property->Value != $iSkipUserId;
		}

		return $ret;
	}

	/**
	 * Retrieve from ExactTarget a list of user IDs that use provided email
	 * @param string $sEmail
	 * @return stdClass
	 * e.g. many results
	 *     stdClass Object (
	 *         [Results] => Array of stdClass Objects
	 *     );
	 * e.g. one result
	 *     stdClass Object (
	 *         [Results] => stdClass Object (
	 *             [Properties] => stdClass Object (
	 *                 [Property] => stdClass Object (
	 *                     [Name] => string
	 *                     [Value] => int
	 *                 )
	 *             )
	 *         )
	 *      );
	 */
	public function retrieveUserIdsByEmail( $sEmail ) {
		$oSimpleFilterPart = $this->wrapSimpleFilterPart( 'user_email', $sEmail );
		$oRetrieveRequest = $this->wrapRetrieveRequest( 'user', [ 'user_id' ], $oSimpleFilterPart );
		$oRetrieveRequestMessage = $this->wrapRetrieveRequestMessage( $oRetrieveRequest );
		return $oClient->Retrieve( $oRetrieveRequestMessage );
	}

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}

	/**
	 * Returns an instance of ExactTargetUserTaskHelper class
	 * @return ExactTargetUserTaskHelper
	 */
	private function getHelper() {
		return new ExactTargetUserTaskHelper();
	}
}
