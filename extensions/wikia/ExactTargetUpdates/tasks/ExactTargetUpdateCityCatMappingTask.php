<?php
use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetUpdateCityCatMappingTask extends BaseTask {

	public function updateCityCatMappingData( Array $aParams ) {
		$oHelper = $this->getHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		$aCityCatMappingDataForRetrieve = $oHelper->prepareCityCatMappingDataExtensionForRetrieve( $aParams['city_id'] );
		$oResults = $oApiDataExtension->retrieveRequest( $aCityCatMappingDataForRetrieve );

		$aCityCatMappingDataForDelete = $oHelper->prepareCityCatMappingDataExtensionForDelete( $oResults );
		$oApiDataExtension->deleteRequest( $aCityCatMappingDataForDelete );

		$aCityCatMappingDataForCreate = [];
		$aCityCatMappingDataForCreate['DataExtension'] = $oHelper->prepareCityCatMappingDataExtensionForCreate( $aParams['city_id'] );
		$oApiDataExtension->createRequest( $aCityCatMappingDataForCreate );
	}

	private function getHelper() {
		return new ExactTargetWikiTaskHelper();
	}

	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}
}
