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
			/* Create new DataExtensionObject that reflects city_list table data */
			$oDE = new ExactTarget_DataExtensionObject();

			/* Get CustomerKeys for current enviroment */
			$aCustomerKeys = $this->getCustomerKeys();
			$oDE->CustomerKey = $aCustomerKeys['city_list'];

			$aApiProperties = [];
			foreach( $aWikiData as $sKey => $sValue ) {
				$aApiProperties[] = $this->wrapApiProperty( $sKey, $sValue );
			}
			$oDE->Properties = $aApiProperties;

			$oSoapVar = $this->wrapToSoapVar( $oDE );

			$oRequest = $this->wrapUpdateRequest( $oSoapVar );

			/* Send API request */
			$oClient->Update( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault: ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}
}
