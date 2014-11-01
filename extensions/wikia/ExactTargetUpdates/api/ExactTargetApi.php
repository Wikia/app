<?php
namespace Wikia\ExactTarget;

use Wikia\Logger\WikiaLogger;

class ExactTargetApi {

	/* @var ExactTargetApiHelper $helper */
	protected $helper;
	protected $client;

	function __construct() {
		$this->getHelper();
		$this->getClient();
	}

	private function getHelper() {
		if ( !isset( $this->helper ) ) {
			$this->helper = new ExactTargetApiHelper();
		}
	}

	private function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = $this->helper->getClient();
		}
	}

	public function makeCreateRequest( Array $aCallObjects ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects );
		$oRequest = $this->helper->wrapCreateRequest( $aSoapVars );
		$oResults = $this->sendRequest( 'Create', $oRequest );
		return $oResults;
	}

	public function makeRetrieveRequest( Array $aCallObjectParams, Array $aSimpleFilterParams ) {
		$oRetrieveRequest = $this->helper->wrapRetrieveRequest( $aCallObjectParams );
		$oSimpleFilterPart = $this->helper->wrapSimpleFilterPart( $aSimpleFilterParams );
		$oRetrieveRequest->Filter = $this->helper->wrapToSoapVar( $oSimpleFilterPart, 'SimpleFilterPart' );
		$oRetrieveRequest->Options = null;
		$oRetrieveRequestMsg = $this->helper->wrapRetrieveRequestMsg( $oRetrieveRequest );
		$oResults = $this->sendRequest( 'Retrieve', $oRetrieveRequestMsg );
		return $oResults;
	}

	public function makeUpdateRequest( Array $aCallObjects ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects );
		$oRequest = $this->helper->wrapUpdateRequest( $aSoapVars );
		$oResults = $this->sendRequest( 'Update', $oRequest );
		return $oResults;
	}

	public function makeUpdateCreateRequest( Array $aCallObjects ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects );
		$oUpdateOptions = $this->helper->prepareUpdateCreateOptions();
		$oRequest = $this->helper->wrapUpdateRequest( $aSoapVars, $oUpdateOptions );
		$oResults = $this->sendRequest( 'Update', $oRequest );
		return $oResults;
	}

	public function makeDeleteRequest( Array $aCallObjects ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects );
		$oDeleteRequest = $this->helper->wrapDeleteRequest( $aSoapVars );
		$oResults = $this->sendRequest( 'Delete', $oDeleteRequest );
		return $oResults;
	}

	protected function sendRequest( $sType, $oRequestObject ) {
		try {
			$oResults = $this->client->$sType( $oRequestObject );
			WikiaLogger::instance()->info( $this->client->__getLastResponse() );
			return $oResults;
		} catch ( SoapFault $e ) {
			/* Log error */
			WikiaLogger::instance()->error( __METHOD__ . "::{$sType} SoapFault: " . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
			return false;
		}
	}
}
