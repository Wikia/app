<?php
namespace Wikia\ExactTarget;

class ExactTargetDeleteUserTask extends ExactTargetTask {

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
		$oRetrieveUserTask = $this->getRetrieveUserTask();
		$sUserEmail = $oRetrieveUserTask->getUserEmail( $iUserId );

		/* Skip deletion if no email found */
		if ( empty( $sUserEmail ) ) {
			$this->info(__METHOD__ . ": No email found for the user or there's no user record. Deletion skipped.");
			return;
		}

		/* Skip deletion if email is used by other account */
		if ( $this->isEmailInUse( $sUserEmail, $iUserId ) ) {
			$this->info(__METHOD__ . ': Email in use by different account (record). Deletion skipped.');
			return;
		}

		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareSubscriberDeleteData( $sUserEmail );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );

		/* Delete subscriber */
		$oDeleteSubscriberResult = $this->doDeleteSubscriber( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oDeleteSubscriberResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oDeleteSubscriberResult ) );
	}

	/**
	 * Sends delete request to actually delete Subscriber object in ExactTarget by API request
	 * @param array $aApiParams
	 */
	private function doDeleteSubscriber( array $aApiParams ) {
		$oApiSubscriber = $this->getApiSubscriber();
		return $oApiSubscriber->deleteRequest( $aApiParams );
	}

	/**
	 * Deletes DataExtension object in ExactTarget by API request
	 * that reflects Wikia entry from user table
	 * @param int $iUserId
	 */
	public function deleteUser( $iUserId ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserDeleteParams( $iUserId );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );
		$oApiDataExtension = $this->getApiDataExtension();

		$oDeleteUserResult = $oApiDataExtension->deleteRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oDeleteUserResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oDeleteUserResult ) );
	}

	/**
	 * Deletes DataExtension objects in ExactTarget by API request
	 * that reflects Wikia entry from user_properties table
	 * @param int $iUserId
	 */
	public function deleteUserProperties( $iUserId ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserPropertiesDeleteParams( $iUserId );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );
		$oApiDataExtension = $this->getApiDataExtension();

		$oDeleteUserPropertiesResult = $oApiDataExtension->deleteRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oDeleteUserPropertiesResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oDeleteUserPropertiesResult ) );
	}

	/**
	 * Checks whether there are any users that has provided email
	 * @param string $sEmail Email address to check in ExactTarget
	 * @param int $iSkipUserId Skip this user ID when checking if email is used by any account
	 * @return bool
	 */
	public function isEmailInUse( $sEmail, $iSkipUserId = null ) {
		$oRetrieveUserTask = $this->getRetrieveUserTask();
		/* @var stdClass $oUsersIds */
		$oUsersIds = $oRetrieveUserTask->retrieveUserIdsByEmail( $sEmail );
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

}
