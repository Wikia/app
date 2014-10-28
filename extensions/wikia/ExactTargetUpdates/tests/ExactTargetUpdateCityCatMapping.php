<?php
class ExactTargetUpdateCityCatMapping extends ExactTargetBaseTask {

	public function updateCityCatMappingData( $aCityCatMappingData ) {
		/* Create a Client object */
		$oClient = $this->getClient();

		/* Make API requests */
		$this->deleteCityCatMappingData( $iCityId, $oClient );
		$this->sendNewCityCatMappingData( $iCityId, $oClient );
	}

	public function deleteCityCatMappingData( $iCityId ) {
		try {
			$oDE = new ExactTarget_DataExtensionObject();

			$oSoapVar = $this->wrapToSoapVar( $oDE );

			$oDeleteRequest = new ExactTarget_DeleteRequest

			$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();
			$oDE->CustomerKey = $aCustomerKeys['city_cat_mapping'];

			$oDE->Keys = [ $this->wrapApiProperty( 'city_id', $iCityId ) ];


		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( __METHOD__ . ' SoapFault ' . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
		}
	}
}
