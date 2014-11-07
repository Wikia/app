<?php
namespace Wikia\ExactTarget;

class ExactTargetUpdateWikiTask extends ExactTargetTask {

	/**
	 * Updates city_list record for a wiki
	 * @param  int $iCityId  A wiki's ID
	 * @return void
	 */
	public function updateWikiData( $iCityId ) {
		$oHelper = $this->getWikiHelper();
		$oApiDataExtension = $this->getApiDataExtension();
		$aDataExtensions = $oHelper->prepareWikiDataExtensionForUpdate( $iCityId );
		$oApiDataExtension->updateRequest( $aDataExtensions );
	}

}
