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
			$oDE = $this->prepareWikiDataForUpdate( $aWikiData );
			$oSoapVar = $this->wrapToSoapVar( $oDE );
			$oRequest = $this->wrapUpdateRequest( $oSoapVar );

			/* Send API request */
			$oClient->Update( $oRequest );

			wfDebug( $oClient->__getLastResponse() . "\n\n" );

			/* Log response */
			$this->info( $oClient->__getLastResponse() . " UpdateTask \n\n" );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault: ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	public function prepareWikiDataForUpdate( $aWikiData ) {
		$oDE = new ExactTarget_DataExtensionObject();

		$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();
		$oDE->CustomerKey = $aCustomerKeys['city_list'];

		$oDE->Keys = [
			$this->wrapApiProperty( 'city_id', $aWikiData['city_id'] ),
		];
		$oDE->Properties = [
			$this->wrapApiProperty( $aWikiData['field'], $aWikiData['value'] ),
		];

		return $oDE;
	}
}
