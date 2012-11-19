<?php
/**
 * Base class for Wikia's API modules based off the Nirvana framework
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

abstract class WikiaApiController extends WikiaController {
	const DEFAULT_FORMAT_INDEX = 0;

	private $allowedFormats = array(
		'json',
		'raw'
	);

	public final function __construct() {
		parent::__construct();

		$query = RequestContext::getMain()->getRequest()->getQueryValues();

		$origQuery = $query;

		ksort($query);

		var_dump($query === $origQuery);exit();

		//throw an error if not in correct order
	}

	/**
	 * Sets the WikiaResponse instance attached to the controller.
	 * For API controllers force json as the output format
	 * @param WikiaResponse $response
	 */
	public function setResponse( WikiaResponse $response ) {
		parent::setResponse( $response );

		$format = $this->response->getFormat();

		//API controllers always return json, with some very
		//exclusive exceptions, also on Dev env and via PHP
		//"raw" is allowed to ease debugging and to allow using
		//API controllers internally
		if ( !in_array( $format, $this->allowedFormats ) ) {
			$format = $this->allowedFormats[self::DEFAULT_FORMAT_INDEX];
		}

		$this->response->setFormat( $format );
	}

	/**
	 * Prints documentation for current controller.
	 * API controller methods are required to return
	 * JSON data but in this case HTML is required.
	 */
	public function help() {
		if ( $this->request->getVal( 'format' ) != 'json' ) {
			$this->response->setFormat( 'html' );
		}

		parent::help();
	}

	/**
	 * Flags the API method as requiring a valid ApiGate Key
	 *
	 * @example
	 * class MyApiController extends WikiaApiController {
	 *     public function myApiMethod() {
	 *         $this->requireKey();
	 *         ...
	 *     }
	 * }
	 */
	protected function requireKey() {
		//defined in /lib/ApiGate/config.php
		global $APIGATE_HEADER_REQUIRES_API;

		//@see ApiGate::requiresApiKey in /lib/ApiGate/ApiGate.class.php
		//Note: this is kinda silly, since if the requirement for a key
		//is not cached in Varnish yet, then the API method will run anyways
		//even if the request doesn't have a valid key... pretty dangerous
		$this->response->setHeader( $APIGATE_HEADER_REQUIRES_API, 1);
	}
}