<?php

class ExactTargetAddWikiTask extends ExactTargetBaseTask {

	public function sendNewWikiData( $aWikiData ) {
		wfDebug( "\n" . print_r( $this, true ) . "\n" );
		$this->createWikiDataExtension( $aWikiData );
		$this->createWikiCatsMappingDataExtension( $aWikiData );
	}

	public function createWikiDataExtension( $aWikiData ) {
		try {
			/* Create new DataExtensionObject that reflects city_list table data */
			$oDE = new ExactTarget_DataExtensionObject();
			$oDE->CustomerKey = 'city_list_dev';

			$aApiProperties = [];
			foreach( $aWikiData as $sKey => $sValue ) {
				$aApiProperties[] = $this->wrapApiProperty( $sKey, $sValue );
			}
			$oDE->Properties = $aApiProperties;

			$oSoapVar = $this->wrapToSoapVar( $oDE );

			$oRequest = $this->wrapCreateRequest( $oSoapVar );

			/* Send API request */
			$this->oClient->Create( $oRequest );

			/* Log response */
			wfDebug( __METHOD__ . " ETCreateWikiTask: WikiDataExtension sent." );
			$this->info( $this->oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			wfDebug( __METHOD__ . " ETCreateWikiTask: WikiDataExtension failed." );
			$this->error( __METHOD__ . ' SoapFault: ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	public function createWikiCatsMappingDataExtension( $aWikiCatsMappingData ) {
		try {
			/*
			 * $aDE is an array to store ExactTarget_DataExtensionObject objects.
			 * $aWikiCatsMappingData can include one or more rows and we need a separate object for each.
			 */
			$aDE = [];
			foreach( $aWikiCatsMappingData as $aSingleCatMapping ) {
				/* Create new DataExtensionObject that reflects city_list table data */
				$oDE = new ExactTarget_DataExtensionObject();
				$oDE->CustomerKey = 'city_cat_mapping_dev';
				
				$aApiProperties = [];
				$aApiProperties[] = $this->wrapApiProperty( 'city_id', $aSingleCatMapping['city_id'] );
				$aApiProperties[] = $this->wrapApiProperty( 'cat_id', $aSingleCatMapping['cat_id'] );
				
				$oDE->Properties = $aApiProperties;
				$aDE[] = $oDE;
			}

			$oSoapVars = $this->prepareSoapVars( $aDE );

			$oRequest = $this->wrapCreateRequest( $oSoapVars );

			/* Send API request */
			$this->oClient->Create( $oRequest );

			/* Log response */
			wfDebug( __METHOD__ . " ETCreateWikiTask: WikiCatsMappingDataExtension sent." );
			$this->info( $this->oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			wfDebug( __METHOD__ . " ETCreateWikiTask: WikiCatsMappingDataExtension failed." );
			$this->error( __METHOD__ . ' SoapFault: ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}
}
