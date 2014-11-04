<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetDeleteUserTask extends BaseTask {

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
		$oRetrieveUserHelper = $this->getRetrieveUserHelper();
		$sUserEmail = $oRetrieveUserHelper->getUserEmail( $iUserId );
		if ( !$this->isEmailInUse( $sUserEmail, $iUserId ) ) {
			$oHelper = $this->getHelper();
			$aApiParams = $oHelper->prepareSubscriberDeleteData( $sUserEmail );
			$this->doDeleteSubscriber( $aApiParams );
		}
	}

	/**
	 * Sends delete request to actually delete Subscriber object in ExactTarget by API request
	 * @param array $aApiParams
	 */
	private function doDeleteSubscriber( array $aApiParams ) {
		$oApiSubscriber = $this->getApiSubscriber();
		$oApiSubscriber->deleteRequest( $aApiParams );
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
	public function deleteUserProperties( $iUserId ) {
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserPropertiesDeleteParams( $iUserId );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->deleteRequest( $aApiParams );
	}

	/**
	 * Checks whether there are any users that has provided email
	 * @param string $sEmail Email address to check in ExactTarget
	 * @param int $iSkipUserId Skip this user ID when checking if email is used by any account
	 * @return bool
	 */
	public function isEmailInUse( $sEmail, $iSkipUserId = null ) {
		$oRetrieveUserHelper = $this->getRetrieveUserHelper();
		/* @var stdClass $oUsersIds */
		$oUsersIds = $oRetrieveUserHelper->retrieveUserIdsByEmail( $sEmail );
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
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}

	/**
	 * Returns an instance of ExactTargetApiSubscriber class
	 * @return ExactTargetApiSubscriber
	 */
	private function getApiSubscriber() {
		return new ExactTargetApiSubscriber();
	}

	/**
	 * Returns an instance of ExactTargetRetrieveUserHelper class
	 * @return ExactTargetRetrieveUserHelper
	 */
	private function getRetrieveUserHelper() {
		return new ExactTargetRetrieveUserHelper();
	}

	/**
	 * Returns an instance of ExactTargetUserTaskHelper class
	 * @return ExactTargetUserTaskHelper
	 */
	private function getHelper() {
		return new ExactTargetUserTaskHelper();
	}
}
