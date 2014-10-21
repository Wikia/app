<?php
namespace Wikia\ExactTarget\Api;

use Wikia\Logger\WikiaLogger;

class ExactTargetApiDataExtension {

	/* @var ExactTargetApiHelper $Helper */
	private $Helper;
	private $Client;

	function __construct() {
		$this->getHelper();
		$this->getClient();
	}

	private function getHelper() {
		if ( !isset( $this->Helper ) ) {
			$this->Helper = new ExactTargetApiHelper();
		}
	}

	private function getClient() {
		if ( !isset( $this->Client ) ) {
			$this->Client = $this->Helper->getClient();
		}
	}

	public function createRequest( Array $aApiCallParams ) {
		$aDE = $this->Helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->Helper->prepareSoapVars( $aDE );
		$oRequest = $this->Helper->wrapCreateRequest( $aSoapVars );

		$oResults = $this->makeRequest( 'Create', $oRequest );
		return $oResults;
	}

	public function retrieveRequest( Array $aApiCallParams ) {
		$oRetrieveRequest = new \ExactTarget_RetrieveRequest();
		$oRetrieveRequest->ObjectType = "DataExtensionObject[{$aApiCallParams['DataExtension']['CustomerKey']}]";
		$oRetrieveRequest->Properties = $aApiCallParams['DataExtension']['Properties'];

		$oSimpleFilterPart = new \ExactTarget_SimpleFilterPart();
		$oSimpleFilterPart->Value = $aApiCallParams['SimpleFilterPart']['Value'];
		$oSimpleFilterPart->SimpleOperator = \ExactTarget_SimpleOperators::equals;
		$oSimpleFilterPart->Property = $aApiCallParams['SimpleFilterPart']['Property'];

		$oRetrieveRequest->Filter = $this->Helper->wrapToSoapVar( $oSimpleFilterPart, 'SimpleFilterPart' );
		$oRetrieveRequest->Options = null;

		$oRetrieveRequestMsg = new \ExactTarget_RetrieveRequestMsg();
		$oRetrieveRequestMsg->RetrieveRequest = $oRetrieveRequest;

		$oResults = $this->makeRequest( 'Retrieve', $oRetrieveRequestMsg );
		return $oResults;
	}

	public function updateRequest( Array $aApiCallParams ) {
		$aDE = $this->Helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->Helper->prepareSoapVars( $aDE );
		$oRequest = $this->Helper->wrapUpdateRequest( $aSoapVars );

		$oResults = $this->makeRequest( 'Update', $oRequest );
		return $oResults;
	}

	public function updateFallbackCreateRequest( Array $aApiCallParams ) {
		$aDE = $this->Helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->Helper->prepareSoapVars( $aDE );
		$oUpdateOptions = $this->prepareUpdateCreateOptions();
		$oRequest = $this->Helper->wrapUpdateRequest( $aSoapVars, $oUpdateOptions );

		$oResults = $this->makeRequest( 'Update', $oRequest );
		return $oResults;
	}

	public function deleteRequest( Array $aApiCallParams ) {
		$aDE = $this->Helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->Helper->prepareSoapVars( $aDE );

		$oDeleteRequest = new \ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new \ExactTarget_DeleteOptions();

		$oResults = $this->makeRequest( 'Delete', $oDeleteRequest );
		return $oResults;
	}

	private function makeRequest( $sType, $oRequestObject ) {
		try {
			$oResults = $this->Client->$sType( $oRequestObject );
			WikiaLogger::instance()->info( $this->Client->__getLastResponse() );
			return $oResults;
		} catch ( SoapFault $e ) {
			/* Log error */
			WikiaLogger::instance()->error( __METHOD__ . "::{$sType} SoapFault: " . $e->getMessage() . ' ErrorCode:  ' . $e->getCode() );
			return false;
		}
	}
}
