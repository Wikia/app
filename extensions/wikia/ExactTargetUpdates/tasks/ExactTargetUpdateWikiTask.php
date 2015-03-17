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
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aDataExtensions ) );

		$oUpdateWikiDataResult = $oApiDataExtension->updateFallbackCreateRequest( $aDataExtensions );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oUpdateWikiDataResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oUpdateWikiDataResult ) );

		if ( $oUpdateWikiDataResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oUpdateWikiDataResult->Results->StatusMessage
			);
		}

		return $oUpdateWikiDataResult->Results->StatusMessage;
	}

}
