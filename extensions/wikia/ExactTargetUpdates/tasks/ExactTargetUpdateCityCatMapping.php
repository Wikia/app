<?php
use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetUpdateCityCatMappingTask extends BaseTask {

	public function updateCityCatMappingData( $aParams ) {
		$oHelper = $this->getHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		$aCityCatMappingDataForRetrieve = $oHelper->prepareCityCatMappingDataForRetrieve( $aParams['city_id'] );
		$oResults = $oApiDataExtension->retrieveRequest( $aCityCatMappingDataForRetrieve );

		$aCityCatMappingDataForDelete = $oHelper->prepareCityCatMappingDataExtensionForDelete( $oResults );
		$oApiDataExtension->deleteRequest( $aCityCatMappingDataForDelete );

		$aCityCatMappingDataForCreate = $oHelper->prepareCityCatMappingDataExtensionForCreate( $iCityId );
		$oApiDataExtension->createRequest( $aCityCatMappingDataForCreate );
	}

	private function getHelper() {
		return new ExactTargetWikiTaskHelper();
	}

	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}
}
