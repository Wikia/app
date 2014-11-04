<?php

use Wikia\Tasks\Tasks\BaseTask;

class ExactTargetBaseTask extends BaseTask {

	/**
	 * Creates ExactTargetSoapClient object containing credentials to connect by API
	 * Note: ExactTargetSoapClient should be called before other ExactTarget classes as it triggers other classes loading
	 * @return ExactTargetSoapClient
	 */
	public function getClient() {
		global $wgExactTargetApiConfig;
		$wsdl = $wgExactTargetApiConfig[ 'wsdl' ];
		$oClient = new ExactTargetSoapClient( $wsdl, array( 'trace'=>1 ) );
		$oClient->username = $wgExactTargetApiConfig[ 'username' ];
		$oClient->password = $wgExactTargetApiConfig[ 'password' ];
		return $oClient;
	}

	/**
	 * Prepares array of SoapVar objects by looping array of objects
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
	 * Wraps ExactTarget object to SoapVar
	 * @param $object
	 * @param string $objectType Type of ExactTarget object to be wrapped
	 * @return SoapVar
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	protected function wrapToSoapVar( $object, $objectType = 'DataExtensionObject' ) {
		return new SoapVar( $object, SOAP_ENC_OBJECT, $objectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}

	/**
	 * Returns ExactTarget_DeleteRequest object with soap vars set from param
	 * @param Array $aSoapVars
	 * @return ExactTarget_DeleteRequest
	 */
	public function wrapDeleteRequest( $aSoapVars ) {
		$oRequest = new ExactTarget_DeleteRequest();
		$oRequest->Options = new ExactTarget_DeleteOptions();
		$oRequest->Objects = $aSoapVars;
		return $oRequest;
	}

	/**
	 * Returns ExactTarget_CreateRequest object with soap vars set from param
	 * @param Array $aSoapVars
	 * @return ExactTarget_CreateRequest
	 */
	public function wrapCreateRequest( $aSoapVars ) {
		$oRequest = new ExactTarget_CreateRequest();
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
		$oRequest = new ExactTarget_UpdateRequest();
		$oRequest->Options = $oOptions;
		$oRequest->Objects = $aSoapVars;
		return $oRequest;
	}

	/**
	 * Prepares ExactTarget_UpdateOptions that says update or add if doesn't exist
	 * @return ExactTarget_UpdateOptions
	 */
	public function prepareUpdateAddOptions() {
		$updateOptions = new ExactTarget_UpdateOptions();

		$saveOption = new ExactTarget_SaveOption();
		$saveOption->PropertyName = 'DataExtensionObject';
		$saveOption->SaveAction = ExactTarget_SaveAction::UpdateAdd;

		$updateOptions->SaveOptions[] = new SoapVar( $saveOption, SOAP_ENC_OBJECT, 'SaveOption', 'http://exacttarget.com/wsdl/partnerAPI' );
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
	protected function wrapApiProperty( $key, $value ) {
		$apiProperty = new ExactTarget_APIProperty();
		$apiProperty->Name = $key;
		$apiProperty->Value = $value;
		return $apiProperty;
	}

	/**
	 * Returns user_id element from $aUserData array and removes it from array
	 * @param array $aUserData key value data from user table
	 * @return int
	 */
	public function extractUserIdFromData( &$aUserData ) {
		$iUserId = $aUserData[ 'user_id' ];
		unset( $aUserData[ 'user_id' ] );
		return $iUserId;
	}

	protected function getLoggerContext() {
		return ['task' => __CLASS__];
	}
}
