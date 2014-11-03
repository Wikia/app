<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetCreateWikiTask extends BaseTask {

	/**
	 * Builds $aDataExtensions array and passes it to a DE API interface.
	 * @param  int $iCityId  A wiki's ID
	 * @return void
	 */
	public function sendNewWikiData( $iCityId ) {
		$oHelper = $this->getHelper();
		$oApiDataExtension = $this->getApiDataExtension();
		$aDataExtensions = $oHelper->prepareDataExtensionsForCreate( $iCityId );
		$oApiDataExtension->createRequest( $aDataExtensions );
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
