<?php
namespace Wikia\ExactTarget;

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
		$sRetrieveObjectType = "DataExtensionObject[{$aApiCallParams['DataExtension']['CustomerKey']}]";
		$aRetrieveProperties = $aApiCallParams['DataExtension']['Properties'];
		$oRetrieveRequest = $this->Helper->wrapRetrieveRequest( $sRetrieveObjectType, $aRetrieveProperties );

		$sFilterProperty = $aApiCallParams['SimpleFilterPart']['Property'];
		$sFilterValue = $aApiCallParams['SimpleFilterPart']['Value'];
		$oSimpleFilterPart = $this->Helper->wrapSimpleFilterPart( $sFilterProperty, $sFilterValue );

		$oRetrieveRequest->Filter = $this->Helper->wrapToSoapVar( $oSimpleFilterPart, 'SimpleFilterPart' );
		$oRetrieveRequest->Options = null;

		$oRetrieveRequestMsg = $this->Helper->wrapRetrieveRequestMsg( $oRetrieveRequest );

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
		$oUpdateOptions = $this->Helper->prepareUpdateCreateOptions();
		$oRequest = $this->Helper->wrapUpdateRequest( $aSoapVars, $oUpdateOptions );

		$oResults = $this->makeRequest( 'Update', $oRequest );
		return $oResults;
	}

	public function deleteRequest( Array $aApiCallParams ) {
		$aDE = $this->Helper->prepareDataExtensionObjects( $aApiCallParams['DataExtension'] );
		$aSoapVars = $this->Helper->prepareSoapVars( $aDE );

		$oDeleteRequest = $this->Helper->wrapDeleteRequest( $aSoapVars );
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
