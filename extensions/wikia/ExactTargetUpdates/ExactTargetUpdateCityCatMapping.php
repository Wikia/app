<?php
class ExactTargetUpdateCityCatMapping extends ExactTargetBaseTask {

	public function updateCityCatMappingData( $aCityCatMappingData ) {
		/* Create a Client object */
		$oClient = $this->getClient();

		/* Make API requests */
		$this->deleteCityCatMappingData( $aCityCatMappingData['categories_old'], $oClient );
		$this->sendNewCityCatMappingData( $aCityCatMappingData['categories_new'], $oClient );
	}

	public function deleteCityCatMappingData( $aOldCategories, $oClient ) {
			$aDE = $this->prepareDataForRemoval( $aOldCategories );

			$aSoapVars = $this->prepareSoapVars( $aDE );

			$oDeleteRequest = new ExactTarget_DeleteRequest
			$oDeleteRequest->Objects = $aSoapVars;
			$oDeleteRequest->Options = new ExactTarget_DeleteOptions();

			$oClient->Delete( $oDeleteRequest );

			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}

	public function sendNewCityCatMappingData( $aNewCategories, $oClient ) {
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
