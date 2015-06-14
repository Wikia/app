<?php
namespace Wikia\ExactTarget;

class ExactTargetApiHelper {

	/**
	 * Creates an ExactTargetSoapClient object containing credentials to connect to the API.
	 * Note: ExactTargetSoapClient should be called before other ExactTarget classes as it triggers other classes loading
	 * @return ExactTargetSoapClient
	 */
	public function getClient() {
		global $wgExactTargetApiConfig;
		$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];
		$oClient = new \ExactTargetSoapClient( $wsdl, [ 'trace' => 1, 'exceptions' => true ] );
		$oClient->username = $wgExactTargetApiConfig[ 'username' ];
		$oClient->password = $wgExactTargetApiConfig[ 'password' ];
		return $oClient;
	}

	/**
	 * Wraps an ExactTarget object to a SoapVar
	 * @param $object
	 * @param string $objectType Type of ExactTarget object to be wrapped
	 * @return SoapVar
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	public function wrapToSoapVar( $oObject, $sObjectType = 'DataExtensionObject' ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $sObjectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}

	/**
	 * Prepares an array of SoapVar objects by looping over an array of objects
	 * @param array $aObjects
	 * @param string $objectType Type of ExactTarget object to be wrapped
	 * @return array
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	public function prepareSoapVars( $aObjects, $sObjectType = 'DataExtensionObject' ) {
		$aSoapVars = [];
		foreach ( $aObjects as $object ) {
			$aSoapVars[] = $this->wrapToSoapVar( $object, $sObjectType );
		}
		return $aSoapVars;
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
	 * Returns a new RetrieveRequest object from prepared params
	 * @param  Array  $aCallObjectParams    An array in the valid format (see API interfaces)
	 * @return ExactTarget_RetrieveRequest  An ExactTarget's request object
	 */
	public function wrapRetrieveRequest( Array $aCallObjectParams ) {
		$oRetrieveRequest = new \ExactTarget_RetrieveRequest();
		$oRetrieveRequest->ObjectType = $aCallObjectParams['ObjectType'];
		$oRetrieveRequest->Properties = $aCallObjectParams['Properties'];
		return $oRetrieveRequest;
	}

	/**
	 * Returns a new SimpleFilterPart object from given parameters
	 * @param  Array  $aSimpleFilterParams  An array with a Property and a Value to match
	 * @return ExactTarget_SimpleFilterPart object
	 */
	public function wrapSimpleFilterPart( Array $aSimpleFilterParams ) {
		$oSimpleFilterPart = new \ExactTarget_SimpleFilterPart();
		$oSimpleFilterPart->Value = $aSimpleFilterParams['Value'];
		if ( isset( $aSimpleFilterParams['SimpleOperator'] ) ) {
			$oSimpleFilterPart->SimpleOperator = $this->getProperSimpleOperator( $aSimpleFilterParams['SimpleOperator'] );
		} else {
			$oSimpleFilterPart->SimpleOperator = \ExactTarget_SimpleOperators::equals;
		}
		$oSimpleFilterPart->Property = $aSimpleFilterParams['Property'];
		return $oSimpleFilterPart;
	}

	/**
	 * Returns a new RetrieveRequestMsg object from prepared params
	 * @param  ExactTarget_RetrieveRequest $oRetrieveRequest  A RetrieveRequest object.
	 * @return ExactTarget_RetrieveRequestMsg object
	 */
	public function wrapRetrieveRequestMsg( \ExactTarget_RetrieveRequest $oRetrieveRequest ) {
		$oRetrieveRequestMsg = new \ExactTarget_RetrieveRequestMsg();
		$oRetrieveRequestMsg->RetrieveRequest = $oRetrieveRequest;
		return $oRetrieveRequestMsg;
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
	 * Returns a new DeleteRequest object from given parameters
	 * @param  Array  $aSimpleFilterParams  An array with a Property and a Value to match
	 * @return ExactTarget_SimpleFilterPart object
	 */
	public function wrapDeleteRequest( $aSoapVars ) {
		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();
		return $oDeleteRequest;
	}

	/**
	 * Prepares ExactTarget_UpdateOptions that says update or create if doesn't exist
	 * @return ExactTarget_UpdateOptions
	 */
	public function prepareUpdateCreateOptions() {
		$updateOptions = new \ExactTarget_UpdateOptions();

		$saveOption = new \ExactTarget_SaveOption();
		$saveOption->PropertyName = 'DataExtensionObject';
		$saveOption->SaveAction = \ExactTarget_SaveAction::UpdateAdd;

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

	/**
	 * Creates an array of DataExtension objects based on passed parameters
	 * @param  array  $aObjectsParams An array of parameters of DataExtension objects'
	 * @return array                  An array of DataExtension objects
	 */
	public function prepareDataExtensionObjects( $aObjectsParams ) {
		$aDE = [];

		foreach ( $aObjectsParams as $aObjectParams ) {
			$oDE = new \ExactTarget_DataExtensionObject();
			$oDE->CustomerKey = $aObjectParams[ 'CustomerKey' ];

			if( isset( $aObjectParams[ 'Properties' ] ) ) {
				$aApiProperties = [];
				foreach ( $aObjectParams[ 'Properties' ] as $sKey => $sValue ) {
					$aApiProperties[] = $this->wrapApiProperty( $sKey, $sValue );
				}
				$oDE->Properties = $aApiProperties;
			}

			if( isset( $aObjectParams[ 'Keys' ] ) ) {
				$aApiKeys = [];
				foreach ( $aObjectParams[ 'Keys' ] as $sKey => $sValue ) {
					$aApiKeys[] = $this->wrapApiProperty( $sKey, $sValue );
				}
				$oDE->Keys = $aApiKeys;
			}

			$aDE[] = $oDE;
		}

		return $aDE;
	}

	/**
	 * Creates an array of Subscriber objects based on passed parameters
	 * @param  array  $aObjectsParams An array of parameters of Subscriber objects'
	 * @return array                  An array of Subscriber objects
	 */
	public function prepareSubscriberObjects( $aObjectsParams ) {
		$aSubscribers = [];

		foreach ( $aObjectsParams as $aSub ) {
			$oSubscriber = new \ExactTarget_Subscriber();
			if ( isset( $aSub['SubscriberKey'] ) ) {
				$oSubscriber->SubscriberKey = $aSub['SubscriberKey'];
			}
			if ( isset( $aSub['EmailAddress'] ) ) {
				$oSubscriber->EmailAddress = $aSub['EmailAddress'];
			}
			$aSubscribers[] = $oSubscriber;
		}

		return $aSubscribers;
	}

	/**
	 * Uses proper compare operator from ExactTarget_SimpleOperators class
	 * @param string $sSimpleOperator
	 * @return null|string
	 */
	protected function getProperSimpleOperator( $sSimpleOperator ) {
		switch( $sSimpleOperator ) {
			case 'equals':
				return \ExactTarget_SimpleOperators::equals;
			case 'IN':
				return \ExactTarget_SimpleOperators::IN;
		}
		return null;
	}
}
