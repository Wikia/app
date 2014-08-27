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
		$this->createUserDE( $aUserData );
		$this->createUserPropertiesDE( $aUserData['user_id'], $aUserProperties );
	}

	/**
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user table
	 * @param Array $aUserData Selected fields from Wikia user table
	 */
	public function createUserDE( $aUserData ) {
		global $wgExactTargetApiConfig;
		$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];

		try {
			/* Create the Soap Client */
			$oClient = new ExactTargetSoapClient( $wsdl, array( 'trace'=>1 ) );
			$oClient->username = $wgExactTargetApiConfig[ 'username' ];
			$oClient->password = $wgExactTargetApiConfig[ 'password' ];

			/* Create new DataExtensionObject that reflects user table data */
			$DE = new ExactTarget_DataExtensionObject();
			/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
			$DE->CustomerKey = "user";

			$apiProperties = [];
			foreach ( $aUserData as $key => $value ) {
				$apiProperties[] = $this->prepareApiProperty( $key,  $value );
			}

			$DE->Properties = $apiProperties;
			$oSoapVar = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', "http://exacttarget.com/wsdl/partnerAPI" );

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

	/**
	 * Creates DataExtension object in ExactTarget by API request that reflects Wikia user_properties table
	 * @param Integer $iUserId User ID
	 * @param Array $aUserProperties key-value array ['property_name'=>'property_value']
	 */
	public function createUserPropertiesDE( $iUserId, $aUserProperties ) {
		global $wgExactTargetApiConfig;
		$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];

		try {
			/* Create the Soap Client */
			$oClient = new ExactTargetSoapClient( $wsdl, array( 'trace'=>1 ) );
			$oClient->username = $wgExactTargetApiConfig[ 'username' ];
			$oClient->password = $wgExactTargetApiConfig[ 'password' ];

			/* @var $aSoapVars Array of SoapVar objects */
			$aSoapVars = [];
			/* Prepare Soap vars */
			foreach ( $aUserProperties as $sProperty => $sValue ) {

				/* Create new DataExtensionObject that reflects user_properties table data */
				$DE = new ExactTarget_DataExtensionObject();
				/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
				$DE->CustomerKey = "user_properties";

				/* @var $apiProperties Array of ExactTarget_APIProperty objects */
				$apiProperties = [];
				$apiProperties[] = $this->prepareApiProperty( 'up_user',  $iUserId );
				$apiProperties[] = $this->prepareApiProperty( 'up_property',  $sProperty );
				$apiProperties[] = $this->prepareApiProperty( 'up_value',  $sValue );

				$DE->Properties = $apiProperties;
				$aSoapVars[] = new SoapVar( $DE, SOAP_ENC_OBJECT, 'DataExtensionObject', "http://exacttarget.com/wsdl/partnerAPI" );
			}

			$oRequest = new ExactTarget_CreateRequest();
			$oRequest->Options = NULL;
			$oRequest->Objects = $aSoapVars;

			/* Call the API to create DataExtension object */
			$oClient->Create( $oRequest );

			/* Log response */
			$this->info( $oClient->__getLastResponse() );

		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
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

	protected function getLoggerContext() {
		return ['task' => __CLASS__];
	}
}
