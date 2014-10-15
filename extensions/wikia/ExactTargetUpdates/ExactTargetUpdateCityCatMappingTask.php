<?php
class ExactTargetUpdateCityCatMappingTask extends ExactTargetBaseTask {

	/**
	 * Wrapper for a task updating city_cat_mapping table
	 * It runs 3 API calls:
	 * 1) Retrieve - to get existing categories
	 * 2) Delete - to delete rows one by one (required by ExactTarget)
	 * 3) Create - to add new city_id->cat_id entries
	 * @param  array $aCityCatMappingData  An array with city_id and new cats
	 */
	public function updateCityCatMappingData( $aCityCatMappingData ) {
		/* Create a Client object */
		$oClient = $this->getClient();

		/* Make API requests */
		$aOldCategories = $this->retrieveOldCityCatMappingData( $aCityCatMappingData['city_id'], $oClient );
		$this->deleteCityCatMappingData( $aOldCategories, $oClient );
		$this->sendNewCityCatMappingData( $aCityCatMappingData['categories_new'], $oClient );
	}

	/**
	 * Retrieve existing rows for a given city_id in city_cat_mapping table
	 * @param  integer               $iCityId  A wiki's ID
	 * @param  ExactTargetSoapClient $oClient  An ExactTarget's client object
	 * @return array                           An array of arrays with city_id and cat_id mapping
	 */
	public function retrieveOldCityCatMappingData( $iCityId, ExactTargetSoapClient $oClient ) {
		try {
			$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();

			/* Retrieve data from city_cat_mapping... */
			$oRetrieveRequest = new ExactTarget_RetrieveRequest();
			$oRetrieveRequest->ObjectType = "DataExtensionObject[{$aCustomerKeys['city_cat_mapping']}]";
			$oRetrieveRequest->Properties = [ 'city_id', 'cat_id' ];

			/* ...and filter it by a given city_id. */
			$oSimpleFilterPart = new ExactTarget_SimpleFilterPart();
			$oSimpleFilterPart->Value = [ $iCityId ];
			$oSimpleFilterPart->SimpleOperator = ExactTarget_SimpleOperators::equals;
			$oSimpleFilterPart->Property = 'city_id';

			$oRetrieveRequest->Filter = $this->wrapToSoapVar( $oSimpleFilterPart, 'SimpleFilterPart' );
			$oRetrieveRequest->Options = null;

			/* Wrap it all in a single object */
			$oRetrieveRequestMsg = new ExactTarget_RetrieveRequestMsg();
			$oRetrieveRequestMsg->RetrieveRequest = $oRetrieveRequest;

			$oResults = $oClient->Retrieve( $oRetrieveRequestMsg );

			/* Convert results (an object with an array of objects) to a simple array */
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

	/**
	 * Sends a requests that deletes all mapping for a given wiki
	 * @param  array                  $aOldCategories  An array retrieved in the first request
	 * @param  ExactTargetSoapClient  $oClient  An ExactTarget's client object
	 */
	public function deleteCityCatMappingData( $aOldCategories, ExactTargetSoapClient $oClient ) {
		try {
			/* Create an array of DataExtension objects and convert them to SOAP vars */
			$aDE = $this->prepareDataForRemoval( $aOldCategories );
			$aSoapVars = $this->prepareSoapVars( $aDE );

			/* Create a new DeleteRequest object */
			$oDeleteRequest = new ExactTarget_DeleteRequest();
			$oDeleteRequest->Objects = $aSoapVars;
			$oDeleteRequest->Options = new ExactTarget_DeleteOptions();

			/* Send a Delete request */
			$oClient->Delete( $oDeleteRequest );

			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	/**
	 * Sends a request that creates new city_cat_mapping entries
	 * @param  array                 $aNewCategories  An array of city_id and new cat_ids
	 * @param  ExactTargetSoapClient $oClient         An ExactTarget's client object
	 */
	public function sendNewCityCatMappingData( $aNewCategories, ExactTargetSoapClient $oClient ) {
		try {
		/*
		 * $aDE is an array to store ExactTarget_DataExtensionObject objects
		 * $aNewCategories can include one or more rows and we need a separate object for each
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

		/* Convert the $aDE array to SOAP vars and create a Create request object */
		$oSoapVars = $this->prepareSoapVars( $aDE );
		$oRequest = $this->wrapCreateRequest( $oSoapVars );

		/* Send  a Create request */
		$oClient->Create( $oRequest );

		/* Log response */
		$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	/**
	 * Converts array of city_ids and cat_ids to an array of DataExtension objects
	 * @param  array $aOldCategories  An array of arrays with city_id and cat_id as keys
	 * @return array                  An array of DataExtension objects
	 */
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
