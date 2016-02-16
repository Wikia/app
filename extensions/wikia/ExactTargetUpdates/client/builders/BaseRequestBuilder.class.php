<?php
namespace Wikia\ExactTarget\Builders;

class BaseRequestBuilder {
	const EXACT_TARGET_API_URL = 'http://exacttarget.com/wsdl/partnerAPI';

	/**
	 * Prepares an array of SoapVar objects by looping over an array of objects
	 *
	 * @param $aObjects
	 * @return array
	 */
	protected function prepareSoapVars( $aObjects, $type ) {
		$aSoapVars = [ ];
		foreach ( $aObjects as $object ) {
			$aSoapVars[] = $this->wrapToSoapVar( $object, $type );
		}
		return $aSoapVars;
	}

	/**
	 * Wraps an ExactTarget object to a SoapVar
	 *
	 * @param $oObject
	 * @param $sObjectType
	 * @return \SoapVar
	 *
	 * @link https://help.exacttarget.com/en/technical_library/web_service_guide/objects/ ExactTarget Objects types
	 */
	protected function wrapToSoapVar( $oObject, $sObjectType ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $sObjectType, self::EXACT_TARGET_API_URL );
	}

}
