<?php
use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetCreateWikiTask extends BaseTask {

	public function sendNewWikiData( $iCityId ) {
		$oHelper = $this->getHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		$aDataExtensions = $oHelper->prepareDataExtensionsForCreate( $iCityId );

		$oApiDataExtension->createRequest( $aDataExtensions );
	}

	private function getHelper() {
		return new ExactTargetWikiTaskHelper();
	}

	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}
}
