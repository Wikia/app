<?php
namespace Wikia\ExactTarget;

class ExactTargetUpdateUserTask extends ExactTargetTask {

	/**
	 * Task for incremental updating number of user contributions on specific wiki
	 * @param array $aUsersEditsData should has following form:
	 * Array (
	 *        {int user id} => [
	 *            [
	 *                'wiki_id' => {wiki id},
	 *                'contributions' => {number of edits}
	 *            ],
	 *            [
	 *                ...
	 *            ]
	 *        ],
	 *        {int user id} => [
	 *                ...
	 *        ]
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
				'Error in ' . __METHOD__ . ': ' . $oUpdateUsersEditsResult->Results[ 0 ]->StatusMessage
			);
		}

		return $oUpdateUsersEditsResult->Results[ 0 ]->StatusMessage;
	}

}
