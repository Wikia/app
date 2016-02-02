<?php
namespace Wikia\ExactTarget;

use Wikia\Logger\WikiaLogger;

class ExactTargetApi {

	/* @var ExactTargetApiHelper $helper */
	protected $helper;

	/* @var ExactTargetSoapClient $client */
	private $client;

	/* @var \WikiaLogger $logger */
	private $logger;

	function __construct() {
		$this->setupHelper();
	}

	/**
	 * Lazy instantiation of an ExactTargetApiHelper class object
	 * @return void
	 */
	private function setupHelper() {
		if ( !isset( $this->helper ) ) {
			$this->helper = new ExactTargetApiHelper();
		}
	}

	/**
	 * Lazy instantiation of an ExactTargetSoapClient class object
	 * @return void
	 */
	private function setupClient() {
		if ( !isset( $this->client ) ) {
			$this->client = $this->helper->getClient();
		}
	}

	/**
	 * Wraps the final Create request and calls sendRequest to push it
	 * @param  Array  $aCallObjects  An array of valid ExactTarget objects (e.g. DataExtension, Subscriber)
	 * @param  string $sObjectType
	 * @return stdClass              An stdClass object with a call's results
	 */
	public function makeCreateRequest( Array $aCallObjects, $sObjectType = 'DataExtensionObject' ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects, $sObjectType );
		$oRequest = $this->helper->wrapCreateRequest( $aSoapVars );
		$oResults = $this->sendRequest( 'Create', $oRequest );
		return $oResults;
	}

	/**
	 * Wraps the final Retrieve request and calls sendRequest to push it
	 * @param  Array  $aCallObjectParams    An array with ObjectType and Properties params
	 * @param  Array  $aSimpleFilterParams  An array with Value and Property of a SimpleFiterPart object
	 * @return stdClass                     An stdClass object with a call's results
	 */
	public function makeRetrieveRequest( Array $aCallObjectParams, Array $aSimpleFilterParams ) {
		$oRetrieveRequest = $this->helper->wrapRetrieveRequest( $aCallObjectParams );
		$oSimpleFilterPart = $this->helper->wrapSimpleFilterPart( $aSimpleFilterParams );
		$oRetrieveRequest->Filter = $this->helper->wrapToSoapVar( $oSimpleFilterPart, 'SimpleFilterPart' );
		$oRetrieveRequest->Options = null;
		$oRetrieveRequestMsg = $this->helper->wrapRetrieveRequestMsg( $oRetrieveRequest );
		$oResults = $this->sendRequest( 'Retrieve', $oRetrieveRequestMsg );
		return $oResults;
	}

	/**
	 * Wraps the final Update request and calls sendRequest to push it
	 * @param  Array  $aCallObjects  An array of valid ExactTarget objects (e.g. DataExtension, Subscriber)
	 * @param  string $sObjectType
	 * @return stdClass              An stdClass object with a call's results
	 */
	public function makeUpdateRequest( Array $aCallObjects, $sObjectType = 'DataExtensionObject' ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects, $sObjectType );
		$oRequest = $this->helper->wrapUpdateRequest( $aSoapVars );
		$oResults = $this->sendRequest( 'Update', $oRequest );
		return $oResults;
	}

	/**
	 * Wraps the final Update request wieh a fallback to Create
	 * and calls sendRequest to push it
	 * @param  Array  $aCallObjects  An array of valid ExactTarget objects (e.g. DataExtension, Subscriber)
	 * @param  string $sObjectType
	 * @return stdClass              An stdClass object with a call's results
	 */
	public function makeUpdateCreateRequest( Array $aCallObjects, $sObjectType = 'DataExtensionObject' ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects, $sObjectType );
		$oUpdateOptions = $this->helper->prepareUpdateCreateOptions();
		$oRequest = $this->helper->wrapUpdateRequest( $aSoapVars, $oUpdateOptions );
		$oResults = $this->sendRequest( 'Update', $oRequest );
		return $oResults;
	}

	/**
	 * Wraps the final Delete request and calls sendRequest to push it
	 * @param  Array  $aCallObjects  An array of valid ExactTarget objects (e.g. DataExtension, Subscriber)
	 * @param  string $sObjectType
	 * @return stdClass              An stdClass object with a call's results
	 */
	public function makeDeleteRequest( Array $aCallObjects, $sObjectType = 'DataExtensionObject' ) {
		$aSoapVars = $this->helper->prepareSoapVars( $aCallObjects, $sObjectType );
		$oDeleteRequest = $this->helper->wrapDeleteRequest( $aSoapVars );
		$oResults = $this->sendRequest( 'Delete', $oDeleteRequest );
		return $oResults;
	}

	/**
	 * Try/catch wrapper for sending API requests
	 * @param  string $sType           Type of a request - Create|Retrieve|Update|Delete
	 * @param  object $oRequestObject  A valid ExactTarget object for a request
	 * @return object|false            Returns false when an Exception is caught and a Results object othwerwise.
	 */
	protected function sendRequest( $sType, $oRequestObject ) {
		try {
			$oResults = $this->getClient()->$sType( $oRequestObject );
			$this->getLogger()->info( $this->getClient()->__getLastResponse() );
			return $oResults;
		} catch ( \SoapFault $e ) {
			$this->getLogger()->error( __METHOD__, [ 'exception' => $e ] );
			return false;
		}
	}

	/**
	 * @return ExactTargetSoapClient
	 */
	protected function getClient() {
		$this->setupClient();
		return $this->client;
	}

	/**
	 * @param \ExactTargetSoapClient $client
	 */
	public function setClient(\ExactTargetSoapClient $client) {
		$this->client = $client;
	}

	/**
	 * @return WikiaLogger
	 */
	protected function getLogger() {
		if ( !isset( $this->logger ) ) {
			$this->logger = WikiaLogger::instance();
		}

		return $this->logger;
	}

	/**
	 * @param WikiaLogger
	 */
	public function setLogger(WikiaLogger $logger) {
		$this->logger = $logger;
	}
}
