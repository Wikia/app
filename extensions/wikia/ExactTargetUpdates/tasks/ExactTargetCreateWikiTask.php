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
		$this->info( __METHOD__ . ' ApiParams: ' . json_encode( $aDataExtensions ) );

		$oCreateWikiResult = $oApiDataExtension->createRequest( $aDataExtensions );

		$this->info( __METHOD__ . ' OverallStatus: ' . $oCreateWikiResult->OverallStatus );
		$this->info( __METHOD__ . ' result: ' . json_encode( (array)$oCreateWikiResult ) );

		if ( $oCreateWikiResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . __METHOD__ . ': ' . $oCreateWikiResult->Results->StatusMessage
			);
		}

		return $oCreateWikiResult->Results->StatusMessage;
	}

}
