<?php
namespace Wikia\ExactTarget;

class ExactTargetCreateUserTask extends ExactTargetTask {

	/**
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user_properties table
	 * @param Integer $iUserId User ID
	 * @param Array $aUserProperties key-value array ['property_name'=>'property_value']
	 * @return bool
	 */
	public function createUserProperties( $iUserId, array $aUserProperties ) {
		$oHelper = $this->getUserHelper();
		$aApiParams = $oHelper->prepareUserPropertiesUpdateParams( $iUserId, $aUserProperties );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aApiParams ) );
		$oApiDataExtension = $this->getApiDataExtension();
		$oCreateUserPropertiesResult = $oApiDataExtension->updateFallbackCreateRequest( $aApiParams );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oCreateUserPropertiesResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oCreateUserPropertiesResult ) );

		if ( $oCreateUserPropertiesResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oCreateUserPropertiesResult->Results[0]->StatusMessage
			);
		}

		$oUserDataVerificationTask = $this->getUserDataVerificationTask();
		$oUserDataVerificationTask->taskId( $this->getTaskId() ); // Pass task ID to have all logs under one task
		$bUserDataVerificationResult = $oUserDataVerificationTask->verifyUserPropertiesData( $iUserId );

		return $bUserDataVerificationResult;
	}

}
