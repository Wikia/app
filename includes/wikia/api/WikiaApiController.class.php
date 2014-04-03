<?php
/**
 * Base class for Wikia's API modules based off the Nirvana framework
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikiaApiController extends WikiaController {
	const DEFAULT_FORMAT_INDEX = 0;
	const API_ENDPOINT_TEST = 'test';
	const API_ENDPOINT_INTERNAL = 'internal';

	private $allowedFormats = array(
		'json',
		'raw'
	);

	public function __construct(){
		parent::__construct();
	}

	/**
	 * block throiwng WikiaException for WikiaApi
	 * if no method is passed
	 *
	 * @private
	 */
	public final function index(){}

	/**
	 * Check if:
	 * controller - is first parameter
	 * method - is second parameter
	 * rest of parameters - are sorted
	 *
	 * @author Jakub Olek <jolek@wikia-inc.com>
	 *
	 * @throws WikiaException
	 */
	final public function init() {
		$webRequest = F::app()->wg->Request;
		$accessService = new ApiAccessService( $this->getRequest() );
		$controller = $webRequest->getVal( 'controller' );
		$method = $webRequest->getVal( 'method' );
		$accessService->checkUse( $controller.'Controller', $method );

		if ( !$this->request->isInternal() ) {
			if ($this->hideNonCommercialContent()) {
				$this->blockIfNonCommercialOnly();				
			}
			$paramKeys = array_keys( $webRequest->getQueryValues() );
			$count = count( $paramKeys );

			if ( $count >= 2 && $paramKeys[0] === 'controller' && $paramKeys[1] === 'method') {

				if ( $count > 2 ) {
					$origParam = $paramKeys = array_flip( array_slice( $paramKeys, 2 ) );

					ksort( $paramKeys );
					ksort( $origParam );

					if ( $paramKeys !== $origParam ) {
						throw new BadRequestApiException( 'The parameters\' order is incorrect' );
					}
				}
			} else {
				throw new BadRequestApiException( 'Controller and/or method missing' );
			}
		}
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
		//defined in /lib/vendor/ApiGate/config.php
		global $APIGATE_HEADER_REQUIRES_API;

		//@see ApiGate::requiresApiKey in /lib/vendor/ApiGate/ApiGate.class.php
		//Note: this is kinda silly, since if the requirement for a key
		//is not cached in Varnish yet, then the API method will run anyways
		//even if the request doesn't have a valid key... pretty dangerous
		$this->response->setHeader( $APIGATE_HEADER_REQUIRES_API, 1);
	}
	
	/**
	 * Returns whether this api request must hide content that is licensed for
	 * non-commercial use only (some of the wikis with unusual license).
	 * Currently, direct requests to wikia.php allow all content (this method returns false),
	 * while requests through /api/v1 entrypoints don't (this method returns true).
	 */
	
	public function hideNonCommercialContent() {
		return stripos($this->request->getScriptUrl(), "/api/v1")===0;
	}
		
	/** Block content if this wiki is does not allow commercial use of it's content outside of Wikia
	 * Raises WikiaHttpException
	 *
	 */
	
	public function blockIfNonCommercialOnly() {
		$licensedService = new LicensedWikisService();
		if (!$licensedService->isCommercialUseAllowedForThisWiki()) {
			throw new ApiNonCommercialOnlyException();
		}
	}
	
	/** Get version of the APIs that caller is trying to use.
	 * Currently there are 3 possible values:
	 * - 'internal' if caller is using wikia.php entrypoint
	 * - '1' if caller is using /api/v1 entrypoint
	 * - 'test' if caller is using /api/test entrypoint
	 */
	public function getApiVersion() {
		$url = $this->request->getScriptUrl();
		if (stripos($this->request->getScriptUrl(), "/api/v1")===0) {
			return 1;
		} else if (stripos($this->request->getScriptUrl(), "/api/test")===0) {
			return self::API_ENDPOINT_TEST;
		} else {
			return self::API_ENDPOINT_INTERNAL;
		}
	}
	
	protected function getSkipMethods() {
		return array_merge(parent::getSkipMethods(),
			['getApiVersion', 'blockIfNonCommercialOnly', 'hideNonCommercialContent']);
	}

	/**
	 * Check whether to serve images (using $wgApiDisableImages)
	 * @return bool
	 */
	protected function serveImages() {
		global  $wgApiDisableImages;
		if($this->request->isInternal() || $this->getApiVersion() == self::API_ENDPOINT_INTERNAL ){
			return true;
		}
		return ( isset( $wgApiDisableImages ) && $wgApiDisableImages === true ) ? false : true;
	}

	/**
	 * @param $data data to set as output
	 * @param string|array $imageFields - fields to remove if we don't serve images
	 * @param int $cacheValidity set only if greater than 0
	 */
	protected function setResponseData( $data, $imageFields = null, $cacheValidity = 0 ) {
		if ( !$this->serveImages() && is_array( $data ) && !empty( $imageFields ) ) {
			if ( !is_array( $imageFields ) ) {
				$imageFields = [ $imageFields ];
			}
			//convert array to [ field_name => N ]
			$imageFields = array_flip( $imageFields );
			self::clear_array( $data, $imageFields );
		}
		$this->response->setData( $data );
		if ( $cacheValidity > 0 ) {
			if ( $this->app->wg->User->isLoggedIn() ) {
				$this->response->setCachePolicy(WikiaResponse::CACHE_PRIVATE);
			} else {
				$this->response->setCacheValidity( $cacheValidity );
			}
		}
	}

	/**
	 * recursive search in array and clean values where key is in "$fields"
	 * @param $input
	 * @param $fields
	 */
	protected static function clear_array( &$input, &$fields ) {
		foreach ( $input as $key => &$val ) {
			$isArray = is_array( $val );
			if ( array_key_exists( $key, $fields ) ) {
				$val = $isArray ? [ ] : null;
			} elseif ( $isArray ) {
				self::clear_array( $val, $fields );
			}
		}
	}

}


class ApiNonCommercialOnlyException extends ForbiddenException {
	protected $details = "API access to this wiki is disabled because it's license disallows commercial use outside of Wikia.";
}
	
	
	
