<?php
namespace Wikia\ExactTarget;

class ExactTargetRequestBuilder {
	const UPDATE_REQUEST = 'update';
	const EXACT_TARGET_API_URL = 'http://exacttarget.com/wsdl/partnerAPI';

	const DATA_EXTENSION_OBJECT_TYPE = 'DataExtensionObject';
	const SAVE_OPTION_TYPE = 'SaveOption';

	private $type;
	private $objects;

	private function __construct( $type ) {
		$this->type = $type;
	}

	/**
	 * @return ExactTargetRequestBuilder
	 */
	public static function createUpdate() {
		return new ExactTargetRequestBuilder( self::UPDATE_REQUEST );
	}

	/**
	 * @param $objects
	 * @return ExactTargetRequestBuilder
	 */
	public function withObjects( $objects ) {
		$this->objects = $objects;
		return $this;
	}

	/**
	 * @return \ExactTarget_UpdateRequest
	 */
	public function build() {
		$oRequest = new \ExactTarget_UpdateRequest();
		$oRequest->Options = $this->prepareUpdateCreateOptions();
		$oRequest->Objects = $this->prepareSoapVars( $this->objects );
		return $oRequest;
	}

	/**
	 * Prepares an array of SoapVar objects by looping over an array of objects
	 *
	 * @param $aObjects
	 * @return array
	 */
	private function prepareSoapVars( $aObjects ) {
		$aSoapVars = [ ];
		foreach ( $aObjects as $object ) {
			$aSoapVars[] = $this->wrapToSoapVar( $object, self::DATA_EXTENSION_OBJECT_TYPE );
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
	private function wrapToSoapVar( $oObject, $sObjectType ) {
		return new \SoapVar( $oObject, SOAP_ENC_OBJECT, $sObjectType, self::EXACT_TARGET_API_URL );
	}

	/**
	 * Prepares ExactTarget_UpdateOptions that says update or create if doesn't exist
	 *
	 * @return \ExactTarget_UpdateOptions
	 */
	private function prepareUpdateCreateOptions() {
		$updateOptions = new \ExactTarget_UpdateOptions();

		$saveOption = new \ExactTarget_SaveOption();
		$saveOption->PropertyName = self::DATA_EXTENSION_OBJECT_TYPE;
		$saveOption->SaveAction = \ExactTarget_SaveAction::UpdateAdd;

		$updateOptions->SaveOptions = [ $this->wrapToSoapVar( $saveOption, self::SAVE_OPTION_TYPE ) ];
		return $updateOptions;
	}
}
