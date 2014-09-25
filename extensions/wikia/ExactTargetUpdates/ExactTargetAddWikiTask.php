<?php

class ExactTargetAddWikiTask extends ExactTargetBaseTask {

	/**
	 * Customer Keys for different enviroments.
	 * Set in ExactTargetUpdatesHelper.
	 * @var array $aCustomerKeys
	 */
	private $aCustomerKeys;

	public function sendNewWikiData( $aWikiData, $aWikiCatsMappingData ) {
		/* Create a Client object */
		$oClient = $this->getClient();

		/* Get Customer Keys for current enviroment */
		$oHelper = new ExactTargetUpdatesHelper();
		$this->aCustomerKeys = $oHelper->getCustomerKeys();

		/* Make API requests */
		$this->createWikiDataExtension( $aWikiData, $oClient );
		$this->createWikiCatsMappingDataExtension( $aWikiCatsMappingData, $oClient );
	}

	public function createWikiDataExtension( $aWikiData, $oClient ) {
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

			$oRequest = $this->wrapCreateRequest( $oSoapVar );

			/* Send API request */
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault: ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	public function createWikiCatsMappingDataExtension( $aWikiCatsMappingData, $oClient ) {
		try {
			/*
			 * $aDE is an array to store ExactTarget_DataExtensionObject objects.
			 * $aWikiCatsMappingData can include one or more rows and we need a separate object for each.
			 */

			$aDE = [];
			foreach( $aWikiCatsMappingData as $aSingleCatMapping ) {
				/* Create new DataExtensionObject that reflects city_list table data */
				$oDE = new ExactTarget_DataExtensionObject();
				$oDE->CustomerKey = $this->aCustomerKeys['city_cat_mapping'];
				
				$aApiProperties = [];
				$aApiProperties[] = $this->wrapApiProperty( 'city_id', $aSingleCatMapping['city_id'] );
				$aApiProperties[] = $this->wrapApiProperty( 'cat_id', $aSingleCatMapping['cat_id'] );
				
				$oDE->Properties = $aApiProperties;
				$aDE[] = $oDE;
			}

			$oSoapVars = $this->prepareSoapVars( $aDE );

			$oRequest = $this->wrapCreateRequest( $oSoapVars );

			/* Send API request */
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault: ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}
}
