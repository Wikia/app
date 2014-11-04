<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetDeleteWikiTask extends BaseTask {

	/**
	 * Perfoms actions necessary to delete ExactTarget records for a wiki
	 * 1. Retrieve city_cat_mapping data
	 * 2. Use the retrieved data to delete city_cat_mapping records
	 * 3. Delete a record from city_list
	 * @param  Array $aParams  Must contain a city_id key
	 * @return void
	 */
	public function deleteWikiData( Array $aParams ) {
		$oHelper = $this->getHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		$aCityCatMappingDataForRetrieve = $oHelper->prepareCityCatMappingDataExtensionForRetrieve( $aParams['city_id'] );
		$oResults = $oApiDataExtension->retrieveRequest( $aCityCatMappingDataForRetrieve );

		$aCityCatMappingDataForDelete = $oHelper->prepareCityCatMappingDataExtensionForDelete( $oResults );
		$oApiDataExtension->deleteRequest( $aCityCatMappingDataForDelete );

		$aWikiDataForDelete = $oHelper->prepareWikiDataExtensionForDelete( $aParams['city_id'] );
		$oApiDataExtension->deleteRequest( $aWikiDataForDelete );
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
