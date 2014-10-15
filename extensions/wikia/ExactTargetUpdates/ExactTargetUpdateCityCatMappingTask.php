<?php
class ExactTargetUpdateCityCatMappingTask extends ExactTargetBaseTask {

	public function updateCityCatMappingData( $aCityCatMappingData ) {
		/* Create a Client object */
		$oClient = $this->getClient();

		/* Make API requests */
		$aOldCategories = $this->retrieveOldCityCatMappingData( $aCityCatMappingData['city_id'], $oClient );
		$this->deleteCityCatMappingData( $aOldCategories, $oClient );
		$this->sendNewCityCatMappingData( $aCityCatMappingData['categories_new'], $oClient );
	}

	public function retrieveOldCityCatMappingData( $iCityId, $oClient ) {
		try {
			$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();

			$oRetrieveRequest = new ExactTarget_RetrieveRequest();
			$oRetrieveRequest->ObjectType = "DataExtensionObject[{$aCustomerKeys['city_cat_mapping']}]";
			$oRetrieveRequest->Properties = [ 'city_id', 'cat_id' ];

			$oSimpleFilterPart = new ExactTarget_SimpleFilterPart();
			$oSimpleFilterPart->Value = [ $iCityId ];
			$oSimpleFilterPart->SimpleOperator = ExactTarget_SimpleOperators::equals;
			$oSimpleFilterPart->Property = 'city_id';

			$oRetrieveRequest->Filter = new SoapVar( $oSimpleFilterPart, SOAP_ENC_OBJECT, 'SimpleFilterPart', "http://exacttarget.com/wsdl/partnerAPI" );
			$oRetrieveRequest->Options = null;

			$oRetrieveRequestMsg = new ExactTarget_RetrieveRequestMsg();
			$oRetrieveRequestMsg->RetrieveRequest = $oRetrieveRequest;

			$oResults = $oClient->Retrieve( $oRetrieveRequestMsg );

			$aOldCategories = [];

			foreach ( $oResults->Results as $oResult ) {
				$oCityId = $oResult->Properties->Property[0];
				$oCatId = $oResult->Properties->Property[1];
				$aOldCategories[] = [
					'city_id' => $oCityId->Value,
					'cat_id' => $oCatId->Value,
				];
			}

			return $aOldCategories;
		} catch ( Exception $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' ExactTargetException ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	public function deleteCityCatMappingData( $aOldCategories, $oClient ) {
		try {
			$aDE = $this->prepareDataForRemoval( $aOldCategories );

			$aSoapVars = $this->prepareSoapVars( $aDE );

			$oDeleteRequest = new ExactTarget_DeleteRequest();
			$oDeleteRequest->Objects = $aSoapVars;
			$oDeleteRequest->Options = new ExactTarget_DeleteOptions();

			$oClient->Delete( $oDeleteRequest );

			$this->info( $oClient->__getLastResponse() );
			wfDebug( 'UpdateCatMapping ' . $oClient->__getLastResponse() . "\n\n" );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	public function sendNewCityCatMappingData( $aNewCategories, $oClient ) {
		try {
		/*
		 * $aDE is an array to store ExactTarget_DataExtensionObject objects.
		 * $aNewCategories can include one or more rows and we need a separate object for each.
		 */
		$aDE = [];
		/* Get Customer Keys specific for production or development */
		$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();

		foreach( $aNewCategories as $aCategory ) {
			/* Create new DataExtensionObject that reflects city_list table data */
			$oDE = new ExactTarget_DataExtensionObject();

			$oDE->CustomerKey = $aCustomerKeys['city_cat_mapping'];

			$aApiProperties = [];
			$aApiProperties[] = $this->wrapApiProperty( 'city_id', $aCategory['city_id'] );
			$aApiProperties[] = $this->wrapApiProperty( 'cat_id', $aCategory['cat_id'] );

			$oDE->Properties = $aApiProperties;
			$aDE[] = $oDE;
		}

		$oSoapVars = $this->prepareSoapVars( $aDE );

		$oRequest = $this->wrapCreateRequest( $oSoapVars );

		/* Send API request */
		$oClient->Create( $oRequest );

		/* Log response */
		$this->info( $oClient->__getLastResponse() );
		wfDebug( 'UpdateCatMapping ' . $oClient->__getLastResponse() . "\n\n" );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	private function prepareDataForRemoval( $aOldCategories ) {
		$aDE = [];

		$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();

		foreach ( $aOldCategories as $aCategory ) {
			$oDE = new ExactTarget_DataExtensionObject();

			$oDE->CustomerKey = $aCustomerKeys['city_cat_mapping'];

			$oDE->Keys = [
				$this->wrapApiProperty( 'city_id', $aCategory['city_id'] ),
				$this->wrapApiProperty( 'cat_id', $aCategory['cat_id'] ),
			];

			$aDE[] = $oDE;
		}

		return $aDE;
	}
}
