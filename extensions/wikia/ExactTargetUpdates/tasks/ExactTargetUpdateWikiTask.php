<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetUpdateWikiTask extends BaseTask {

	/**
	 * Updates city_list record for a wiki
	 * @param  int $iCityId  A wiki's ID
	 * @return void
	 */
	public function updateWikiData( $iCityId ) {
		$oHelper = $this->getHelper();
		$oApiDataExtension = $this->getApiDataExtension();
		$aDataExtensions = $oHelper->prepareWikiDataExtensionForUpdate( $iCityId );
		$oApiDataExtension->updateRequest( $aDataExtensions );
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
