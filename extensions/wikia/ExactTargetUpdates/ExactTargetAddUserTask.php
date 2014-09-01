<?php

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetAddUserTask extends BaseTask {

	/**
	 * Task for creating all necessary objects in ExactTarget related to newly created user
	 * @param array $aUserData Selected fields from Wikia user table
	 * @param array $aUserProperties Array of Wikia user gobal properties
	 */
	public function sendNewUserData( $aUserData, $aUserProperties = array() ) {
		$this->createSubscriber( $aUserData['user_email'] );
		$this->createUserDataExtension( $aUserData );
		$this->createUserPropertiesDataExtension( $aUserData['user_id'], $aUserProperties );
	}

	/**
	 * Creates Subscriber object in ExactTarget by API request
	 * @param String $sUserEmail new subscriber email address
	 */
	public function createSubscriber( $sUserEmail ) {
		global $wgExactTargetApiConfig;
		$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];

		try {
			/* Create the Soap Client */
			$oClient = new ExactTargetSoapClient( $wsdl, array( 'trace'=>1 ) );
			$oClient->username = $wgExactTargetApiConfig[ 'username' ];
			$oClient->password = $wgExactTargetApiConfig[ 'password' ];

			/* ExactTarget_Subscriber */
			$oSubscriber = new ExactTarget_Subscriber();
			$oSubscriber->SubscriberKey = $sUserEmail;
			$oSubscriber->EmailAddress = $sUserEmail;

			/* Create the subscriber */
			$oSoapVar = new SoapVar( $oSubscriber, SOAP_ENC_OBJECT, 'Subscriber', 'http://exacttarget.com/wsdl/partnerAPI' );
			$oRequest = new ExactTarget_CreateRequest();
			$oRequest->Options = NULL;
			$oRequest->Objects = array( $oSoapVar );
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	/**
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user table
	 * @param Array $aUserData Selected fields from Wikia user table
	 */
	public function createUserDataExtension( $aUserData ) {

		try {
			/* Create the Soap Client */
			$oClient = $this->getClient();

			/* Create new DataExtensionObject that reflects user table data */
			$DE = new ExactTarget_DataExtensionObject();
			/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
			$DE->CustomerKey = 'user';

			$apiProperties = [];
			foreach ( $aUserData as $key => $value ) {
				$apiProperties[] = $this->prepareApiProperty( $key,  $value );
			}

			$DE->Properties = $apiProperties;
			$oSoapVar = $this->wrapDataExtensionObjectToSoapVar( $DE );

			$oRequest = new ExactTarget_CreateRequest();
			$oRequest->Options = NULL;
			$oRequest->Objects = array( $oSoapVar );
			$oClient->Create( $oRequest );

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
	public function createUserPropertiesDataExtension( $iUserId, $aUserProperties ) {

		$oRequest = $this->prepareRequest( $iUserId, $aUserProperties );

		try {
			/* Create the Soap Client */

			$oClient = $this->getClient();
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	protected function prepareUserPropertiesSoapVars( $iUserId, $aUserProperties ) {

		$aDE = $this->prepareUserPropertiesDataExtensionObjects( $iUserId, $aUserProperties );

		$aSoapVars = [];
		foreach( $aDE as $DE ) {
			$aSoapVars[] = $this->wrapDataExtensionObjectToSoapVar( $DE );
		}
		return $aSoapVars;
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
			$apiProperties[] = $this->prepareApiProperty( 'up_user',  $iUserId );
			$apiProperties[] = $this->prepareApiProperty( 'up_property',  $sProperty );
			$apiProperties[] = $this->prepareApiProperty( 'up_value',  $sValue );

			$DE->Properties = $apiProperties;
			$aDE[] = $DE;
		}
		return $aDE;
	}

	public function getClient() {
		global $wgExactTargetApiConfig;
		$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];
		$oClient = new ExactTargetSoapClient( $wsdl, array( 'trace'=>1 ) );
		$oClient->username = $wgExactTargetApiConfig[ 'username' ];
		$oClient->password = $wgExactTargetApiConfig[ 'password' ];
	}

	public function prepareRequest( $iUserId, $aUserProperties ) {
		$aSoapVars = $this->prepareUserPropertiesSoapVars( $iUserId, $aUserProperties );

		$oRequest = new ExactTarget_CreateRequest();
		$oRequest->Options = NULL;
		$oRequest->Objects = $aSoapVars;
		return $oRequest;
	}

	protected function wrapDataExtensionObjectToSoapVar( $DE ) {
		return new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', 'http://exacttarget.com/wsdl/partnerAPI' );
	}

	/**
	 * Returns ExactTarget_APIProperty object
	 * This object can be used as ExactTarget_DataExtensionObject property
	 * It stores key-value pair
	 * @param String $key Property name
	 * @param String $value Propert yvalue
	 * @return ExactTarget_APIProperty
	 */
	private function  prepareApiProperty( $key, $value ) {
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = $key;
		$apiProperty->Value = $value;
		return $apiProperty;
	}

	protected function getLoggerContext() {
		return ['task' => __CLASS__];
	}
}
