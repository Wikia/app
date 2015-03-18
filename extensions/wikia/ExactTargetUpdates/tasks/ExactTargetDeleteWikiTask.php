<?php
namespace Wikia\ExactTarget;

class ExactTargetDeleteWikiTask extends ExactTargetTask {

	/**
	 * Perfoms actions necessary to delete ExactTarget records for a wiki
	 * 1. Retrieve city_cat_mapping data
	 * 2. Use the retrieved data to delete city_cat_mapping records
	 * 3. Delete a record from city_list
	 * @param  Array $aParams  Must contain a city_id key
	 * @return void
	 */
	public function deleteWikiData( Array $aParams ) {
		$oHelper = $this->getWikiHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		// Retrieve city category mapping data for removal
		$aCityCatMappingDataForRetrieve = $oHelper->prepareCityCatMappingDataExtensionForRetrieve( $aParams['city_id'] );
		$this->info( 'RetrieveCityCatMapping' . ' ApiParams: ' . json_encode( $aCityCatMappingDataForRetrieve ) );
		$oResults = $oApiDataExtension->retrieveRequest( $aCityCatMappingDataForRetrieve );
		$this->info( 'RetrieveCityCatMapping' . ' OverallStatus: ' . $oResults->OverallStatus );
		$this->info( 'RetrieveCityCatMapping' . ' result: ' . json_encode( (array)$oResults ) );

		if ( $oResults->OverallStatus !== 'OK' ) {
			throw new \Exception(
				'Error in ' . 'RetrieveCityCatMapping' . ': ' . $oResults->OverallStatus
			);
		}

		if ( isset( $oResults->Results ) ) {
			// Delete city category mapping
			$aCityCatMappingDataForDelete = $oHelper->prepareCityCatMappingDataExtensionForDelete( $oResults );
			$this->info( 'DeleteCityCatMapping' . ' ApiParams: ' . json_encode( $aCityCatMappingDataForDelete ) );
			$oCityCatMappingDeleteResult = $oApiDataExtension->deleteRequest( $aCityCatMappingDataForDelete );
			$this->info( 'DeleteCityCatMapping' . ' OverallStatus: ' . $oCityCatMappingDeleteResult->OverallStatus );
			$this->info( 'DeleteCityCatMapping' . ' result: ' . json_encode( (array)$oCityCatMappingDeleteResult ) );

			if ( $oCityCatMappingDeleteResult->OverallStatus === 'Error' ) {
				throw new \Exception(
					'Error in ' . 'DeleteCityCatMapping' . ': ' . $oCityCatMappingDeleteResult->Results->StatusMessage
				);
			}
		} else {
			$this->info( 'No city cats found for the wiki, no cats deleted.' );
		}

		// Delete wiki data
		$aWikiDataForDelete = $oHelper->prepareWikiDataExtensionForDelete( $aParams['city_id'] );
		$this->info( 'DeleteWikiData' . ' ApiParams: ' . json_encode( $aWikiDataForDelete ) );
		$oWikiDeleteResult = $oApiDataExtension->deleteRequest( $aWikiDataForDelete );
		$this->info( 'DeleteWikiData' . ' OverallStatus: ' . $oWikiDeleteResult->OverallStatus );
		$this->info( 'DeleteWikiData' . ' result: ' . json_encode( ( array )$oWikiDeleteResult ) );

		if ( $oWikiDeleteResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . 'DeleteWikiData' . ': ' . $oWikiDeleteResult->Results->StatusMessage
			);
		}

		return $oWikiDeleteResult->Results->StatusMessage;
	}


}
