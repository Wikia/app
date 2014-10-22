<?php
use Wikia\Logger\WikiaLogger;

class ExactTargetApiSubscriber {

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
		$aSubscribers = $this->Helper->prepareSubscriberObjects( $aApiCallParams );

		$oRequest = new ExactTargetCreateRequest();
		$oRequest->Options = null;
		$oRequest->Objects = $aSubscribers;

		$this->makeRequest( 'Create', $oRequest );
	}

	public function retrieveRequest( Array $aApiCallParams ) {
		$sRetrieveObjectType = "Subscriber";
		$aRetrieveProperties = $aApiCallParams['Subscriber']['Properties'];
		$oRetrieveRequest = $this->Helper->makeRetrieveRequestObject( $sRetrieveObjectType, $aRetrieveProperties );

		$sFilterProperty = $aApiCallParams['SimpleFilterPart']['Property'];
		$sFilterValue = $aApiCallParams['SimpleFilterPart']['Value'];
		$oSimpleFilterPart = $this->Helper->makeSimpleFilterPartObject( $sFilterProperty, $sFilterValue );

		$oRetrieveRequest->Filter = $this->Helper->wrapToSoapVar( $oSimpleFilterPart, 'SimpleFilterPart' );
		$oRetrieveRequest->Options = null;

		$oRetrieveRequestMsg = $this->Helper->makeRetrieveRequestMsgObject( $oRetrieveRequest );

		$oResults = $this->makeRequest( 'Retrieve', $oRetrieveRequestMsg );
		return $oResults;
	}

	public function deleteRequest( Array $aApiCallParams ) {
		$aSubscribers = $this->Helper->prepareSubscriberObjects( $aApiCallParams['Subscriber'] );
		$aSoapVars = $this->Helper->prepareSoapVars( $aSubscribers, 'Subscriber' );
		
		$oDeleteRequest = new ExactTarget_DeleteRequest();
		$oDeleteRequest->Objects = $aSoapVars;
		$oDeleteRequest->Options = new ExactTarget_DeleteOptions();

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
