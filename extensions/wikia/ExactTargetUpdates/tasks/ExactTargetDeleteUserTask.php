<?php
namespace Wikia\ExactTarget;

class ExactTargetDeleteUserTask extends ExactTargetTask {

	/**
	 * Task for removing user data in ExactTarget
	 * @param int $iUserId Id of user to be deleted
	 */
	public function deleteUserData( $iUserId ) {
		$this->attemptDeleteSubscriber( $iUserId );
		$this->deleteUser( $iUserId );
		$this->deleteUserProperties( $iUserId );
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
	 * @param int $userId
	 */
	private function attemptDeleteSubscriber( $userId ) {
		$client = new ExactTargetClient();

		$userEmail = $client->retrieveEmailByUserId( $userId );
		if ( empty( $userEmail ) ) {
			return;
		}

		$ids = $this->retrieveUserIdsByEmail( $userEmail );
		/* Skip deletion if no email found or email used by other account */
		if ( !empty( $ids ) && ( count( $ids ) > 1 || $ids[0] != $userId ) ) {
			return;
		}

		$client->deleteSubscriber( $userEmail );
	}
}
