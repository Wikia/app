<?php
namespace Wikia\ExactTarget;

class ExactTargetCreateWikiTask extends ExactTargetTask {

	/**
	 * Runs wiki data updates to ExactTarget
	 * (contents of city_list table and city_cat_mapping)
	 * @param  int $iCityId  A wiki's ID
	 * @return array
	 */
	public function sendNewWikiData( $iCityId ) {
		$oUpdateWikiTask = $this->getUpdateWikiHelper();
		$sCityListResult = $oUpdateWikiTask->updateFallbackCreateWikiData( $iCityId );
		$sCityCatResult = $this->createCityCatMapping( $iCityId );

		$aResult = [
			'updateFallbackCreateCityList' => $sCityListResult,
			'createCityCatMapping' => $sCityCatResult,
		];
		return $aResult;
	}

	/**
	 * Create city_cat_mapping records for a wiki in ExactTarget
	 * Builds $aDataExtensions array and passes it to a DE API interface.
	 * @param int $iCityId A wiki's ID
	 * @return string
	 * @throws \Exception
	 */
	public function createCityCatMapping( $iCityId ) {
		$oHelper = $this->getWikiHelper();
		$oApiDataExtension = $this->getApiDataExtension();
		$aDataExtensions = $oHelper->prepareCityCatMappingDataExtensionForCreate( $iCityId );
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aDataExtensions ) );

		$oCreateWikiResult = $oApiDataExtension->createRequest( $aDataExtensions );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oCreateWikiResult->OverallStatus );
		$this->info( __METHOD__ . ' Result: ' . json_encode( (array)$oCreateWikiResult ) );

		if ( $oCreateWikiResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__
			);
		}

		return $oCreateWikiResult->OverallStatus;
	}

}
