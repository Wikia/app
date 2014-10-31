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

	public function retrieveRequest( Array $aApiCallParams, $sRetrieveObjectType, Array $aRetrieveProperties ) {
		$oRetrieveRequest = $this->helper->wrapRetrieveRequest( $sRetrieveObjectType, $aRetrieveProperties );

		$sFilterProperty = $aApiCallParams['SimpleFilterPart']['Property'];
		$sFilterValue = $aApiCallParams['SimpleFilterPart']['Value'];
		$oSimpleFilterPart = $this->helper->wrapSimpleFilterPart( $sFilterProperty, $sFilterValue );

		$oRetrieveRequest->Filter = $this->helper->wrapToSoapVar( $oSimpleFilterPart, 'SimpleFilterPart' );
		$oRetrieveRequest->Options = null;

		$oRetrieveRequestMsg = $this->helper->wrapRetrieveRequestMsg( $oRetrieveRequest );

		$oResults = $this->makeRequest( 'Retrieve', $oRetrieveRequestMsg );
		return $oResults;
	}

	protected function makeRequest( $sType, $oRequestObject ) {
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
