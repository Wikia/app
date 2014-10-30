<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetDeleteWikiTask extends BaseTask {

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

	private function getHelper() {
		return new ExactTargetWikiTaskHelper();
	}

	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}
}
