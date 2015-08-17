<?php
namespace Wikia\ExactTarget;

class ExactTargetUpdateCityCatMappingTask extends ExactTargetTask {

	/**
	 * Perfoms actions necessary to update a city_cat_mapping record
	 * 1. Retrieve city_cat_mapping data
	 * 2. Delete the retrieved city_cat_mapping records
	 * 3. Create new records
	 * @param  Array $aParams  Must contain a city_id key
	 * @return void
	 */
	public function updateCityCatMappingData( Array $aParams ) {
		$oHelper = $this->getWikiHelper();
		$oApiDataExtension = $this->getApiDataExtension();

		// Retrieve city category mapping data for removal
		$aCityCatMappingDataForRetrieve = $oHelper->prepareCityCatMappingDataExtensionForRetrieve( $aParams['city_id'] );
		$sRetrieveLogHead = __METHOD__ . ' RetrieveCityCatMapping';
		$this->info( $sRetrieveLogHead . ' ApiParams: ' . json_encode( $aCityCatMappingDataForRetrieve ) );
		$oResults = $oApiDataExtension->retrieveRequest( $aCityCatMappingDataForRetrieve );
		$this->info( $sRetrieveLogHead . ' OverallStatus: ' . $oResults->OverallStatus );
		$this->info( $sRetrieveLogHead . ' Result: ' . json_encode( (array)$oResults ) );

		if ( $oResults->OverallStatus !== 'OK' ) {
			throw new \Exception(
				'Error in ' . $sRetrieveLogHead . ': ' . $oResults->OverallStatus
			);
		}

		if ( isset( $oResults->Results ) ) {
			// Delete city category mapping
			$aCityCatMappingDataForDelete = $oHelper->prepareCityCatMappingDataExtensionForDelete( $oResults );
			$sDeleteLogHead = __METHOD__ . ' DeleteCityCatMapping';
			$this->info( $sDeleteLogHead . ' ApiParams: ' . json_encode( $aCityCatMappingDataForDelete ) );
			$oCityCatMappingDeleteResult = $oApiDataExtension->deleteRequest( $aCityCatMappingDataForDelete );
			$this->info( $sDeleteLogHead . ' OverallStatus: ' . $oCityCatMappingDeleteResult->OverallStatus );
			$this->info( $sDeleteLogHead . ' Result: ' . json_encode( (array)$oCityCatMappingDeleteResult ) );

			if ( $oCityCatMappingDeleteResult->OverallStatus === 'Error' ) {
				throw new \Exception(
					'Error in ' . $sDeleteLogHead . ': ' . $oCityCatMappingDeleteResult->Results->StatusMessage
				);
			}
		} else {
			$this->info('No city cats found for the wiki, no cats deleted.');
		}

		// Create city category mapping using fresh data from DB
		$aCityCatMappingDataForCreate = $oHelper->prepareCityCatMappingDataExtensionForCreate( $aParams['city_id'] );
		$sCreateLogHead = __METHOD__ . ' CreateCityCatMapping';
		$this->info( $sCreateLogHead . ' ApiParams: ' . json_encode( $aCityCatMappingDataForCreate ) );
		$oWikiCreateResult = $oApiDataExtension->createRequest( $aCityCatMappingDataForCreate );
		$this->info( $sCreateLogHead . ' OverallStatus: ' . $oWikiCreateResult->OverallStatus );
		$this->info( $sCreateLogHead . ' Result: ' . json_encode( (array)$oWikiCreateResult ) );

		if ( $oWikiCreateResult->OverallStatus === 'Error' ) {
			throw new \Exception(
				'Error in ' . $sCreateLogHead
			);
		}

		// Return OverallStatus if multiple records were inserted and StatusMessage if just one
		return is_array($oWikiCreateResult->Results)
			? $oWikiCreateResult->OverallStatus
			: $oWikiCreateResult->Results->StatusMessage;
	}

}
