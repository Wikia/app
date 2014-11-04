<?php

class ExactTargetAddUserTask extends ExactTargetBaseTask {

	/**
	 * Task for creating all necessary objects in ExactTarget related to newly created user
	 * @param array $aUserData Selected fields from Wikia user table
	 * @param array $aUserProperties Array of Wikia user gobal properties
	 */
	public function updateAddUserData( $aUserData, $aUserProperties ) {
		$oClient = $this->getClient();
		/* Remove subscriber (email address) used by touched user */
		$oRemoveUserTask = $this->getRemoveUserTaskObject();
		$oRemoveUserTask->removeSubscriber( $aUserData['user_id'], $oClient );
		/* Create Subscriber with new email */
		$this->createSubscriber( $aUserData['user_email'], $oClient );
		/* Create User DataExtension with new email */
		$this->createUserDataExtension( $aUserData, $oClient );
		/* Create User Properties DataExtension with new email */
		$this->createUserPropertiesDataExtension( $aUserData['user_id'], $aUserProperties, $oClient );
	}

	/**
	 * Creates Subscriber object in ExactTarget by API request
	 * @param String $sUserEmail new subscriber email address
	 */
	public function createSubscriber( $sUserEmail, $oClient ) {
		try {
			/* ExactTarget_Subscriber */
			$oSubscriber = new ExactTarget_Subscriber();
			$oSubscriber->SubscriberKey = $sUserEmail;
			$oSubscriber->EmailAddress = $sUserEmail;

			/* Create the subscriber */
			$oSoapVar = $this->wrapToSoapVar( $oSubscriber, 'Subscriber' );
			$oRequest = $this->wrapCreateRequest( [ $oSoapVar ] );

			/* Send API request */
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	/**
	 * Creates (or updates if already exists) DataExtension object in ExactTarget by API request that reflects Wikia user table
	 * @param Array $aUserData Selected fields from Wikia user table
	 */
	public function createUserDataExtension( $aUserData, $oClient ) {

		try {
			/* Create new DataExtensionObject that reflects user table data */
			$oDE = new ExactTarget_DataExtensionObject();
			/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
			$oDE->CustomerKey = 'user';

			$userId = $this->extractUserIdFromData( $aUserData );

			$apiProperties = [];
			foreach ( $aUserData as $key => $value ) {
				$apiProperties[] = $this->wrapApiProperty( $key,  $value );
			}
			$oDE->Properties = $apiProperties;

			/* Prepare query keys */
			$oDE->Keys = [ $this->wrapApiProperty( 'user_id',  $userId ) ];

			$oSoapVar = $this->wrapToSoapVar( $oDE );

			$oUpdateOptions = $this->prepareUpdateAddOptions();

			$oRequest = $this->wrapUpdateRequest( [ $oSoapVar ], $oUpdateOptions );

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
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user_properties table
	 * @param Integer $iUserId User ID
	 * @param Array $aUserProperties key-value array ['property_name'=>'property_value']
	 */
	public function createUserPropertiesDataExtension( $iUserId, $aUserProperties, $oClient ) {

		try {
			$aDE = $this->prepareUserPropertiesDataExtensionObjects( $iUserId, $aUserProperties );
			$aSoapVars = $this->prepareSoapVars( $aDE );
			$oRequest = $this->wrapCreateRequest( $aSoapVars );

			/* Send API request */
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	protected function prepareUserPropertiesDataExtensionObjects( $iUserId, $aUserProperties ) {
		$aDE = [];
		foreach ( $aUserProperties as $sProperty => $sValue ) {
			/* Create new DataExtensionObject that reflects user_properties table data */
			$DE = new ExactTarget_DataExtensionObject();
			/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
			$DE->CustomerKey = 'user_properties';

			/* @var $apiProperties Array of ExactTarget_APIProperty objects */
			$apiProperties = [];
			$apiProperties[] = $this->wrapApiProperty( 'up_user',  $iUserId );
			$apiProperties[] = $this->wrapApiProperty( 'up_property',  $sProperty );
			$apiProperties[] = $this->wrapApiProperty( 'up_value',  $sValue );

			$DE->Properties = $apiProperties;
			$aDE[] = $DE;
		}
		return $aDE;
	}

	/**
	 * Returns an instance of ExactTargetRemoveUserTask class
	 * @return ExactTargetRemoveUserTask
	 */
	protected function getRemoveUserTaskObject() {
		return new ExactTargetRemoveUserTask();
	}
}
