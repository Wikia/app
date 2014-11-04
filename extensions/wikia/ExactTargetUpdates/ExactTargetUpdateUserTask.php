<?php

class ExactTargetUpdateUserTask extends ExactTargetBaseTask {

	/**
	 * Task for updating user data in ExactTarget
	 * @param array $aUserData Selected fields from Wikia user table
	 */
	public function updateUserData( $aUserData ) {
		$oClient = $this->getClient();
		$this->updateUserDataExtension( $aUserData, $oClient );
	}

	/**
	 * Sends update of user email to ExactTarget
	 * @param int $iUserId
	 * @param string $iUserEmail
	 */
	public function updateUserEmail( $iUserId, $iUserEmail ) {
		$oClient = $this->getClient();

		/* Subscriber list contains unique emails
		 * Assuming email may be new - try to create subscriber object using the email */
		$addUserTask = $this->getAddUserTaskObject();
		$addUserTask->createSubscriber( $iUserEmail, $oClient );

		/* Update email in user data extension */
		$aUserData = [
			'user_id' => $iUserId,
			'user_email' => $iUserEmail
		];
		$this->updateUserDataExtension( $aUserData, $oClient );
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
	 * Updates DataExtension object in ExactTarget by API request that reflects Wikia user table
	 * @param Array $aUserData Selected fields from Wikia user table
	 */
	public function updateUserDataExtension( $aUserData, $oClient ) {

		try {
			$oDE = $this->prepareUserDataExtensionObjectsForUpdate( $aUserData );
			$oSoapVar = $this->wrapToSoapVar( $oDE );
			$oRequest = $this->wrapUpdateRequest( [ $oSoapVar ] );

			/* Send API update request */
			$oClient->Update( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
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
	 * Prepares array of ExactTarget_DataExtensionObject objects for user table
	 * that can be used to send API update
	 * @param array $aUserData user key value array
	 * @return ExactTarget_DataExtensionObject
	 */
	public function prepareUserDataExtensionObjectsForUpdate( $aUserData ) {

		$userId = $this->extractUserIdFromData( $aUserData );
		/* Create new DataExtensionObject that reflects user table data */
		$oDE = new ExactTarget_DataExtensionObject();
		/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
		$oDE->CustomerKey = 'user';

		/* Prapare update data */
		$apiProperties = [];
		foreach ( $aUserData as $key => $value ) {
			$apiProperties[] = $this->wrapApiProperty( $key,  $value );
		}
		$oDE->Properties = $apiProperties;

		/* Prepare query keys */
		$oDE->Keys = [ $this->wrapApiProperty( 'user_id',  $userId ) ];

		return $oDE;
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
			$DE = new ExactTarget_DataExtensionObject();
			/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
			$DE->CustomerKey = 'user_properties';

			/* @var $keys Array of ExactTarget_APIProperty objects - select criteria */
			$keys = [];
			$keys[] = $this->wrapApiProperty( 'up_user', $iUserId );
			$keys[] = $this->wrapApiProperty( 'up_property', $sProperty );
			$DE->Keys = $keys;

			/* @var $properties Array of ExactTarget_APIProperty objects - value for update */
			$properties = [];
			$properties[] = $this->wrapApiProperty( 'up_value', $sValue );
			$DE->Properties = $properties;

			$aDE[] = $DE;
		}
		return $aDE;
	}

	/**
	 * Returns an instance of ExactTargetAddUserTask class
	 * @return ExactTargetAddUserTask
	 */
	protected function getAddUserTaskObject() {
		return new ExactTargetAddUserTask();
	}
}
