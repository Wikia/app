<?php

class ExactTargetUpdateWikiTask extends ExactTargetBaseTask {

	/**
	 * Customer Keys for different enviroments.
	 * Set in ExactTargetUpdatesHelper.
	 * @var array $aCustomerKeys
	 */
	private $aCustomerKeys;

	public function updateWikiData( $aWikiData ) {
		/* Create a Client object */
		$oClient = $this->getClient();

		/* Get Customer Keys for current enviroment */
		$oHelper = new ExactTargetUpdatesHelper();
		$this->aCustomerKeys = $oHelper->getCustomerKeys();

		/* Make API requests */
		$this->updateWikiDataExtension( $aWikiData, $oClient );
	}

	public function updateWikiDataExtension( $aWikiData, $oClient ) {
		try {
			/* Create new DataExtensionObject that reflects city_list table data */
			$oDE = new ExactTarget_DataExtensionObject();
			$oDE->CustomerKey = $this->aCustomerKeys['city_list'];

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
