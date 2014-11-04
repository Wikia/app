<?php
namespace Wikia\ExactTarget;

class ExactTargetUpdateCityCatMappingTask extends ExactTargetTask {

	/**
	 * Perfoms actions necessary to update a city_cat_mapping record
	 * 1. Retrieve city_cat_mapping data
	 * 2. Delete the retrieved city_cat_mapping records
	 * 3. Create new records
	 * @param  Array $aParams  Must contain a city_id key
	 * @return void
	 */
	public function updateCityCatMappingData( Array $aParams ) {
		$oHelper = $this->getWikiHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		$aCityCatMappingDataForRetrieve = $oHelper->prepareCityCatMappingDataExtensionForRetrieve( $aParams['city_id'] );
		$oResults = $oApiDataExtension->retrieveRequest( $aCityCatMappingDataForRetrieve );

		$aCityCatMappingDataForDelete = $oHelper->prepareCityCatMappingDataExtensionForDelete( $oResults );
		$oApiDataExtension->deleteRequest( $aCityCatMappingDataForDelete );

		$aCityCatMappingDataForCreate = [];
		$aCityCatMappingDataForCreate['DataExtension'] = $oHelper->prepareCityCatMappingDataExtensionForCreate( $aParams['city_id'] );
		$oApiDataExtension->createRequest( $aCityCatMappingDataForCreate );
	}

}
