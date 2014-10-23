<?php
namespace Wikia\ExactTarget\Api;

class ExactTargetApiHelper {

	/**
	 * Creates an ExactTargetSoapClient object containing credentials to connect to the API.
	 * Note: ExactTargetSoapClient should be called before other ExactTarget classes as it triggers other classes loading
	 * @return ExactTargetSoapClient
	 */
	public function getClient() {
		global $wgExactTargetApiConfig;
		$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];
		$oClient = new \ExactTargetSoapClient( $wsdl, array( 'trace'=>1 ) );
		$oClient->username = $wgExactTargetApiConfig[ 'username' ];
		$oClient->password = $wgExactTargetApiConfig[ 'password' ];
		return $oClient;
	}

	/**
	 * Prepares an array of SoapVar objects by looping over an array of objects
	 * @param array $aObjects
	 * @param string $objectType Type of ExactTarget object to be wrapped
	 * @return array
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	public function prepareSoapVars( $aObjects, $objectType = 'DataExtensionObject' ) {
		$aSoapVars = [];
		foreach( $aObjects as $object ) {
			$aSoapVars[] = $this->wrapToSoapVar( $object, $objectType );
		}
		return $aSoapVars;
	}

	/**
	 * Wraps an ExactTarget object to a SoapVar
	 * @param $object
	 * @param string $objectType Type of ExactTarget object to be wrapped
	 * @return SoapVar
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	public function wrapToSoapVar( $object, $objectType = 'DataExtensionObject' ) {
		return new \SoapVar( $object, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}

	/**
	 * Returns ExactTarget_CreateRequest object with soap vars set from param
	 * @param Array $aSoapVars
	 * @return ExactTarget_CreateRequest
	 */
	public function wrapCreateRequest( $aSoapVars ) {
		$oRequest = new \ExactTarget_CreateRequest();
		$oRequest->Options = NULL;
		$oRequest->Objects = $aSoapVars;
		return $oRequest;
	}

	/**
	 * Returns ExactTarget_UpdateRequest object with soap vars set from param
	 * @param Array $aSoapVars
	 * @param ExactTarget_UpdateOptions|null $oOptions Null for simple update;
	 *        ExactTarget_UpdateOptions for update-add etc.
	 * @return ExactTarget_UpdateRequest
	 */
	public function wrapUpdateRequest( $aSoapVars, $oOptions = null ) {
		$oRequest = new \ExactTarget_UpdateRequest();
		$oRequest->Options = $oOptions;
		$oRequest->Objects = $aSoapVars;
		return $oRequest;
	}

	/**
	 * Prepares ExactTarget_UpdateOptions that says update or create if doesn't exist
	 * @return ExactTarget_UpdateOptions
	 */
	public function prepareUpdateCreateOptions() {
		$updateOptions = new \ExactTarget_UpdateOptions();

		$saveOption = new \ExactTarget_SaveOption();
		$saveOption->PropertyName = 'DataExtensionObject';
		$saveOption->SaveAction = ExactTarget_SaveAction::UpdateAdd;

		$updateOptions->SaveOptions[] = new \SoapVar( $saveOption, SOAP_ENC_OBJECT, 'SaveOption', 'http://exacttarget.com/wsdl/partnerAPI' );
		return $updateOptions;
	}

	/**
	 * Returns ExactTarget_APIProperty object
	 * This object can be used as ExactTarget_DataExtensionObject property
	 * It stores key-value pair
	 * @param String $key Property name
	 * @param String $value Propert yvalue
	 * @return ExactTarget_APIProperty
	 */

	public function wrapApiProperty( $key, $value ) {
		$apiProperty = new \ExactTarget_APIProperty();
		$apiProperty->Name = $key;
		$apiProperty->Value = $value;
		return $apiProperty;
	}

	public function makeRetrieveRequestObject( $sObjectType, Array $aProperties ) {
		$oRetrieveRequest = new ExactTarget_RetrieveRequest();
		$oRetrieveRequest->ObjectType = $sObjectType;
		$oRetrieveRequest->Properties = $aProperties;

		return $oRetrieveRequest;
	}

	public function makeSimpleFilterPartObject( $sProperty, $sValue ) {
		$oSimpleFilterPart = new ExactTarget_SimpleFilterPart();
		$oSimpleFilterPart->Value = $sValue;
		$oSimpleFilterPart->SimpleOperator = ExactTarget_SimpleOperators::equals;
		$oSimpleFilterPart->Property = $sProperty;

		return $oSimpleFilterPart;
	}

	public function makeRetrieveRequestMsgObject( $oRetrieveRequest ) {
		$oRetrieveRequestMsg = new ExactTarget_RetrieveRequestMsg();
		$oRetrieveRequestMsg->RetrieveRequest = $oRetrieveRequest;

		return $oRetrieveRequestMsg;
	}

	/**
	 * Creates an array of DataExtension objects
	 * based on passed parameters.
	 * @param  array  $aObjectsParams An array of parameters of DataExtension objects'
	 * @return array                  An array of DataExtension objects
	 */
	public function prepareDataExtensionObjects( $aObjectsParams ) {
		$aDE = [];
		foreach( $aObjectsParams as $aObjectParams ) {
			$oDE = new \ExactTarget_DataExtensionObject();
			$oDE->CustomerKey = $aObjectParams[ 'CustomerKey' ];

			if( isset( $aObjectParams[ 'Properties' ] ) ) {
				$aApiProperties = [];
				foreach( $aObjectParams[ 'Properties' ] as $sKey => $sValue ) {
					$aApiProperties[] = $this->wrapApiProperty( $sKey, $sValue );
				}
				$oDE->Properties = $aApiProperties;
			}

			if( isset( $aObjectParams[ 'Keys' ] ) ) {
				$aApiKeys = [];
				foreach( $aObjectParams[ 'Keys' ] as $sKey => $sValue ) {
					$aApiKeys[] = $this->wrapApiProperty( $sKey, $sValue );
				}
				$oDE->Keys = $aApiKeys;
			}

			$aDE[] = $oDE;
		}
		return $aDE;
	}
	
	public function prepareSubscriberObjects( $aObjects ) {
		$aSubscribers = [];

		foreach ( $aObjects as $aSub ) {
			$oSubscriber = new ExactTarget_Subscriber();
			$oSubscriber->SubscriberKey = $aSub['SubscriberKey'];
			$oSubscriber->EmailAddress = $aSub['EmailAddress'];
			
			$aSubscribers[] = $this->wrapToSoapVar( $oSubscriber, 'Subscriber' );
		}

		return $aSubscribers;
	}
}
