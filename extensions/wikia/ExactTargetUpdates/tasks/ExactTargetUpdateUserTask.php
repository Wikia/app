<?php
namespace Wikia\ExactTarget;

class ExactTargetUpdateUserTask extends ExactTargetTask {

	/**
	 * Here was
	 * public function updateUserData( $aUserData )
	 * Task for updating user data in ExactTarget
	 *
	 * @info Removed updateUserData method as was unused
	 * @commit 9efbaa4f3a148445d8fa5cef4d2842184c6ba577
	 *
	 * @param array $aUserData Selected fields from Wikia user table
	 */

	/**
	 * Task for creating a record with user group and user in ExactTarget
	 * @param int $iUserId
	 * @param string $sGroup name of added group
	 */
	public function addUserGroup( $iUserId, $sGroup ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserGroupCreateParams( $iUserId, [ $sGroup ] );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );
		$oApiDataExtension = $this->getApiDataExtension();
		$oAddUserGroupResult = $oApiDataExtension->createRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oAddUserGroupResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oAddUserGroupResult ) );

		if ( $oAddUserGroupResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oAddUserGroupResult->Results->StatusMessage
			);
		}

		return $oAddUserGroupResult->Results->StatusMessage;
	}

	/**
	 * Task for removing a record with user group and user in ExactTarget
	 * @param int $iUserId
	 * @param string $sGroup name of removed group
	 */
	public function removeUserGroup( $iUserId, $sGroup ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserGroupRemoveParams( $iUserId, [ $sGroup ] );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );
		$oApiDataExtension = $this->getApiDataExtension();
		$oRemoveUserGroupResult = $oApiDataExtension->deleteRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oRemoveUserGroupResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oRemoveUserGroupResult ) );

		if ( $oRemoveUserGroupResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oRemoveUserGroupResult->Results->StatusMessage
			);
		}

		return $oRemoveUserGroupResult->Results->StatusMessage;
	}

	/**
	 * Task for incremental updating number of user contributions on specific wiki
	 * @param array $aUsersEditsData should has following form:
	 * Array (
	 * 		{int user id} => [
	 * 			[
	 * 				'wiki_id' => {wiki id},
	 * 				'contributions' => {number of edits}
	 * 			],
	 * 			[
	 * 				...
	 * 			]
	 * 		],
	 * 		{int user id} => [
	 * 				...
	 * 		]
	 * )
	 */
	public function updateUsersEdits( array $aUsersEditsData ) {
		$aUsersIds = array_keys( $aUsersEditsData );
		$this->info( __METHOD__ . ' Params - User IDs: ' . json_encode( $aUsersIds ) );

		// Get number of edits from ExactTarget
		$oRetrieveUserTask = $this->getRetrieveUserTask();
		$oRetrieveUserTask->taskId( $this->getTaskId() );
		$aUserEditsDataFromET = $oRetrieveUserTask->retrieveUserEdits( $aUsersIds );

		// Merge number of edits from ExactTarget with incremental data that came as a function parameter
		$oHelper = $this->getUserHelper();
		$oHelper->mergeUsersEditsData( $aUsersEditsData, $aUserEditsDataFromET );

		// Send update request to update number of edits
		$oApiDataExtension = $this->getApiDataExtension();
		$aApiParams = $oHelper->prepareUserEditsUpdateParams( $aUsersEditsData );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );
		$oUpdateUsersEditsResult = $oApiDataExtension->updateFallbackCreateRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oUpdateUsersEditsResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oUpdateUsersEditsResult ) );

		if ( $oUpdateUsersEditsResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oUpdateUsersEditsResult->Results[0]->StatusMessage
			);
		}

		return $oUpdateUsersEditsResult->Results[0]->StatusMessage;
	}

}
