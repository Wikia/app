<?php
namespace Wikia\ExactTarget;

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetUpdateWikiTask extends BaseTask {

	public function updateWikiData( $iCityId ) {
		$oHelper = $this->getHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		$aDataExtensions = $oHelper->prepareWikiDataExtensionForUpdate( $iCityId );

		$oApiDataExtension->updateRequest( $aDataExtensions );
	}

	private function getHelper() {
		return new ExactTargetWikiTaskHelper();
	}

	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}
}
