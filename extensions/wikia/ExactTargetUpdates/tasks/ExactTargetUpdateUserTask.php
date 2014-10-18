<?php

class ExactTargetUpdateUserTask {

	/**
	 * Task for updating user data in ExactTarget
	 * @param array $aUserData Selected fields from Wikia user table
	 */
	public function updateUserData( $aUserData ) {
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserDataExtensionParamsForUpdate( $aUserData );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->updateRequest( $aApiParams );
	}

	/**
	 * Sends update of user email to ExactTarget
	 * @param int $iUserId
	 * @param string $iUserEmail
	 */
	public function updateUserEmail( $iUserId, $iUserEmail ) {
		/* Subscriber list contains unique emails
		 * Assuming email may be new - try to create subscriber object using the email */
		$addUserTask = $this->getAddUserTaskObject();
		$addUserTask->createSubscriber( $iUserEmail );

		/* Update email in user data extension */
		$aUserData = [
			'user_id' => $iUserId,
			'user_email' => $iUserEmail
		];
		$oHelper = $this->getHelper();
		$aApiParams = $oHelper->prepareUserDataExtensionParamsForUpdate( $aUserData );
		$oApiDataExtension = $this->getApiDataExtension();
		$oApiDataExtension->updateRequest( $aApiParams );
	}

	/**
	 * Task for updating user_properties data in ExactTarget
	 * @param array $aUserData Selected fields from Wikia user table
	 * @param array $aUserProperties Array of Wikia user gobal properties
	 */
	public function updateUserPropertiesData( $aUserData, $aUserProperties ) {
		$oClient = $this->getClient();
		$this->updateUserPropertiesDataExtension( $aUserData['user_id'], $aUserProperties, $oClient );
	}

	/**
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user_properties table
	 * @param Integer $iUserId User ID
	 * @param Array $aUserProperties key-value array ['property_name'=>'property_value']
	 */
	public function updateUserPropertiesDataExtension( $iUserId, $aUserProperties, $oClient ) {

		try {
			$aDE = $this->prepareUserPropertiesDataExtensionObjectsForUpdate( $iUserId, $aUserProperties );
			$aSoapVars = $this->prepareSoapVars( $aDE );
			$oRequest = $this->wrapUpdateRequest( $aSoapVars );

			/* Send API request */
			$oClient->Update( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}



	/**
	 * Prepares array of ExactTarget_DataExtensionObject objects for user_properties table
	 * that can be used to send API update
	 * @param int $iUserId User id
	 * @param array $aUserProperties user_properties key value array
	 * @return array of ExactTarget_DataExtensionObject objects
	 */
	public function prepareUserPropertiesDataExtensionObjectsForUpdate( $iUserId, $aUserProperties ) {

		$aDE = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {

			/* Create new DataExtensionObject that reflects user_properties table data */
			$oDE = new ExactTarget_DataExtensionObject();

			/* Get Customer Keys specific for production or development */
			$aCustomerKeys = ExactTargetUpdatesHelper::getCustomerKeys();
			$oDE->CustomerKey = $aCustomerKeys['user_properties'];

			/* @var $keys Array of ExactTarget_APIProperty objects - select criteria */
			$keys = [];
			$keys[] = $this->wrapApiProperty( 'up_user', $iUserId );
			$keys[] = $this->wrapApiProperty( 'up_property', $sProperty );
			$oDE->Keys = $keys;

			/* @var $aProperties Array of ExactTarget_APIProperty objects - value for update */
			$aProperties = [];
			$aProperties[] = $this->wrapApiProperty( 'up_value', $sValue );
			$oDE->Properties = $aProperties;

			$aDE[] = $oDE;
		}
		return $aDE;
	}

	/**
	 * Returns an instance of ExactTargetAddUserTask class
	 * @return ExactTargetAddUserTask
	 */
	private function getAddUserTaskObject() {
		return new ExactTargetAddUserTask();
	}

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	private function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}

	/**
	 * Returns an instance of ExactTargetUserTaskHelper class
	 * @return ExactTargetUserTaskHelper
	 */
	private function getHelper() {
		return new ExactTargetUserTaskHelper();
	}
}
