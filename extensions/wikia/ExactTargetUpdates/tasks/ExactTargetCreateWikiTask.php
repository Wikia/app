<?php
namespace Wikia\ExactTarget;

class ExactTargetCreateWikiTask extends ExactTargetTask {

	/**
	 * Builds $aDataExtensions array and passes it to a DE API interface.
	 * @param  int $iCityId  A wiki's ID
	 * @return void
	 */
	public function sendNewWikiData( $iCityId ) {
		$oHelper = $this->getWikiHelper();
		$oApiDataExtension = $this->getApiDataExtension();
		$aDataExtensions = $oHelper->prepareDataExtensionsForCreate( $iCityId );
		$oApiDataExtension->createRequest( $aDataExtensions );
	}

}
