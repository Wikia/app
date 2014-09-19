<?php

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetAddUserTask extends BaseTask {
	private $oClient;

	public function __construct() {
		$this->initClient();
	}

	/**
	 * Task for creating all necessary objects in ExactTarget related to newly created user
	 * @param array $aUserData Selected fields from Wikia user table
	 * @param array $aUserProperties Array of Wikia user gobal properties
	 */
	public function sendNewUserData( $aUserData, $aUserProperties ) {
		$this->createSubscriber( $aUserData['user_email'] );
		$this->createUserDataExtension( $aUserData );
		$this->createUserPropertiesDataExtension( $aUserData['user_id'], $aUserProperties );
	}

	/**
	 * Creates Subscriber object in ExactTarget by API request
	 * @param String $sUserEmail new subscriber email address
	 */
	public function createSubscriber( $sUserEmail ) {
		try {
			/* ExactTarget_Subscriber */
			$oSubscriber = new ExactTarget_Subscriber();
			$oSubscriber->SubscriberKey = $sUserEmail;
			$oSubscriber->EmailAddress = $sUserEmail;

			/* Create the subscriber */
			$oSoapVar = $this->wrapToSoapVar( $oSubscriber, 'Subscriber' );
			$oRequest = $this->wrapRequest( [ $oSoapVar ] );

			/* Send API request */
			$this->oClient->Create( $oRequest );

			/* Log response */
			$this->info( $this->oClient->__getLastResponse() );

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
			/* Create new DataExtensionObject that reflects user table data */
			$DE = new ExactTarget_DataExtensionObject();
			/* CustomerKey is a key that indicates Wikia table reflected by DataExtension */
			$DE->CustomerKey = 'user';

			$apiProperties = [];
			foreach ( $aUserData as $key => $value ) {
				$apiProperties[] = $this->wrapApiProperty( $key,  $value );
			}
			$DE->Properties = $apiProperties;

			$oSoapVar = $this->wrapToSoapVar( $DE );

			$oRequest = $this->wrapRequest( [ $oSoapVar ] );

			/* Send API request */
			$this->oClient->Create( $oRequest );

			/* Log response */
			$this->info( $this->oClient->__getLastResponse() );

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

		try {
			$aSoapVars = $this->prepareUserPropertiesSoapVars( $iUserId, $aUserProperties );
			$oRequest = $this->wrapRequest( $aSoapVars );

			/* Send API request */
			$this->oClient->Create( $oRequest );

			/* Log response */
			$this->info( $this->oClient->__getLastResponse() );
		} catch ( SoapFault $e ) {
			/* Log error */
			$this->error( 'SoapFault:' . $e->getMessage() . 'ErrorCode: ' . $e->getCode() );
		}
	}

	public function prepareUserPropertiesSoapVars( $iUserId, $aUserProperties ) {

		$aDE = $this->prepareUserPropertiesDataExtensionObjects( $iUserId, $aUserProperties );

		$aSoapVars = [];
		foreach( $aDE as $DE ) {
			$aSoapVars[] = $this->wrapToSoapVar( $DE );
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
			$apiProperties[] = $this->wrapApiProperty( 'up_user',  $iUserId );
			$apiProperties[] = $this->wrapApiProperty( 'up_property',  $sProperty );
			$apiProperties[] = $this->wrapApiProperty( 'up_value',  $sValue );

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
		return $oClient;
	}

	public function initClient() {
		$this->oClient = $this->getClient();
	}

	public function wrapRequest( $aSoapVars ) {
		$oRequest = new ExactTarget_CreateRequest();
		$oRequest->Options = NULL;
		$oRequest->Objects = $aSoapVars;
		return $oRequest;
	}

	protected function wrapToSoapVar( $object, $objectType = 'DataExtensionObject' ) {
		return new SoapVar( $object, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}

	/**
	 * Returns ExactTarget_APIProperty object
	 * This object can be used as ExactTarget_DataExtensionObject property
	 * It stores key-value pair
	 * @param String $key Property name
	 * @param String $value Propert yvalue
	 * @return ExactTarget_APIProperty
	 */
	protected function wrapApiProperty( $key, $value ) {
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = $key;
		$apiProperty->Value = $value;
		return $apiProperty;
	}

	protected function getLoggerContext() {
		return ['task' => __CLASS__];
	}
}
