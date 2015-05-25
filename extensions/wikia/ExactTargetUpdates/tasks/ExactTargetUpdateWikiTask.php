<?php
namespace Wikia\ExactTarget;

class ExactTargetUpdateWikiTask extends ExactTargetTask {

	/**
	 * Updates city_list data with fallback to create in ExactTarget
	 * Builds $aDataExtensions array and passes it to a DE API interface.
	 * @param  int $iCityId  A wiki's ID
	 * @return bool
	 */
	public function updateFallbackCreateWikiData( $iCityId ) {
		$oHelper = $this->getWikiHelper();
		$oApiDataExtension = $this->getApiDataExtension();
		$aDataExtensions = $oHelper->prepareWikiDataExtensionForUpdate( $iCityId );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aDataExtensions ) );

		$oUpdateWikiDataResult = $oApiDataExtension->updateFallbackCreateRequest( $aDataExtensions );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oUpdateWikiDataResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oUpdateWikiDataResult ) );

		if ( $oUpdateWikiDataResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oUpdateWikiDataResult->Results->StatusMessage
			);
		}

		/* Verify data */
		$oWikiDataVerificationTask = $this->getWikiDataVerificationTask();
		$oWikiDataVerificationTask->taskId( $this->getTaskId() ); // Pass task ID to have all logs under one task
		$bWikiDataVerificationResult = $oWikiDataVerificationTask->verifyWikiData( $iCityId );

		return $bWikiDataVerificationResult;
	}

}
