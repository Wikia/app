<?php

class ExactTargetUpdateWikiTask extends ExactTargetBaseTask {

	public function updateWikiData( $aWikiData ) {
		/* Create a Client object */
		$oClient = $this->getClient();

		/* Make API requests */
		$this->updateWikiDataExtension( $aWikiData, $oClient );
	}

	public function updateWikiDataExtension( $aWikiData, $oClient ) {
		try {
			/* Create new DataExtension object */
			$oDE = new ExactTarget_DataExtensionObject();

			/* Set CustomerKey */
			$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();
			$oDE->CustomerKey = $aCustomerKeys['city_list'];

			/* Set key for selecting a wiki's record */
			$oDE->Keys = [ $this->wrapApiProperty( 'city_id', $aWikiData['city_id'] ) ];

			/**
			 * Unset all we don't want to update
			 * city_id must never change
			 * city_vertical is updated by an ExactTargetUpdateWikiCatsMappingTask class
			 */
			unset( $aWikiData['city_id'] );
			unset( $aWikiData['city_vertical'] );

			/* Prepare DataExtension's properties from $aWikiData */
			$aApiProperties = [];
			foreach ( $aWikiData as $key => $value ) {
				$aApiProperties[] = $this->wrapApiProperty( $key, $value );
			}
			$oDE->Properties = $aApiProperties;

			/* Prepare SOAP and request objects */
			$oSoapVar = $this->wrapToSoapVar( $oDE );
			$oRequest = $this->wrapUpdateRequest( $oSoapVar );

			/* Send API request */
			$oClient->Update( $oRequest );

			/* Log response */
			wfDebug( $oClient->__getLastResponse() . "\n\n" );
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault: ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}
}
