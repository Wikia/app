<?php
namespace Wikia\ExactTarget;

class ExactTargetRequestBuilder {

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
	 * Wraps an ExactTarget object to a SoapVar
	 * @param $object
	 * @param string $objectType Type of ExactTarget object to be wrapped
	 * @return SoapVar
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	private function wrapToSoapVar( $oObject, $sObjectType = 'DataExtensionObject' ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $sObjectType, 'http://exacttarget.com/wsdl/partnerAPI' );
	}
}
