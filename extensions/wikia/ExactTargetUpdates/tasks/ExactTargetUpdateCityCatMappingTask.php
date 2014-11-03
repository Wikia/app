<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetUpdateCityCatMappingTask extends BaseTask {

	/**
	 * Perfoms actions necessary to update a city_cat_mapping record
	 * 1. Retrieve city_cat_mapping data
	 * 2. Delete the retrieved city_cat_mapping records
	 * 3. Create new records
	 * @param  Array $aParams  Must contain a city_id key
	 * @return void
	 */
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

	/**
	 * A simple getter for an object of an ExactTargetWikiTaskHelper class
	 * @return object ExactTargetWikiTaskHelper
	 */
	private function getHelper() {
		return new ExactTargetWikiTaskHelper();
	}

	/**
	 * A simple getter for an object of an ExactTargetApiDataExtension class
	 * @return object ExactTargetApiDataExtension
	 */
	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}
}
