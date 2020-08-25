<?php

/**
 * Nirvana Framework - Response class
 *
 * @ingroup nirvana
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 * @author Owen Davis <owen(at)wikia-inc.com>
 * @author Wojciech Szela <wojtek(at)wikia-inc.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class WikiaResponse {
	/**
	 * Response codes
	 *
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	 */
	const RESPONSE_CODE_OK = 200;
	const RESPONSE_CODE_CREATED = 201;
	const RESPONSE_CODE_INTERNAL_SERVER_ERROR  = 500;
	const RESPONSE_CODE_ERROR = 501;
	const RESPONSE_CODE_SERVICE_UNAVAILABLE = 503;
	const RESPONSE_CODE_BAD_REQUEST = 400;
	const RESPONSE_CODE_FORBIDDEN = 403;
	const RESPONSE_CODE_NOT_FOUND = 404;
	const RESPONSE_CODE_METHOD_NOT_ALLOWED = 405;

	/**
	 * Output formats
	 */
	const FORMAT_RAW = 'raw';	// deprecated (PLATFORM-2770)
	const FORMAT_HTML = 'html';
	const FORMAT_JSON = 'json';
	const FORMAT_JSONP = 'jsonp';
	const FORMAT_INVALID = 'invalid';

	/**
	 * template engine
	 */
	const TEMPLATE_ENGINE_PHP = 'php';
	const TEMPLATE_ENGINE_MUSTACHE = 'mustache';

	/**
	 * Caching times
	 */
	const CACHE_DISABLED = 0;

	const CACHE_LONG = 2592000; // 30 days
	const CACHE_STANDARD = 86400; // 24 hours
	const CACHE_SHORT = 10800; // 3 hours
	const CACHE_VERY_SHORT = 300; // 5 minutes

	const CACHE_PRIVATE = 'private';
	const CACHE_PUBLIC = 'public';
	const CACHE_ANON_PUBLIC_USER_PRIVATE = 'anon-public-user-private';

	/**
	 * Caching policy
	 */
	private $cachingPolicy = self::CACHE_ANON_PUBLIC_USER_PRIVATE;

	/**
	 * View object
	 * @var WikiaView
	 */
	private $view = null;
	private $body = null;
	private $code = null;
	private $contentType = null;
	private $headers = array();
	private $format = null;
	private $templateEngine = self::TEMPLATE_ENGINE_PHP;
	private $skinName = null;
	private $controllerName = null;
	private $methodName = null;
	private $request = null;
	private $jsVars = array();
	protected $data = array();
	protected $exception = null;

	/**
	 * Flag for whether we're caching
	 * @var bool
	 */
	protected $isCaching = false;

	/**
	 * constructor
	 * @param string $format
	 * @param WikiaRequest $request
	 */
	public function __construct( $format, $request = null ) {
		$this->setFormat( $format );
		$this->setView( new WikiaView( $this ) );
		$this->setRequest( $request );
	}

	public function setRequest( $request ) {
		$this->request = $request;
	}

	/**
	 * @return WikiaRequest
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * set exception
	 * @param Exception $exception
	 */
	public function setException( Exception $exception ) {
		$this->exception = $exception;
	}

	/**
	 * get view
	 * @return WikiaView
	 */
	public function getView() {
		return $this->view;
	}

	/**
	 * set view
	 * @param WikiaView $view
	 */
	public function setView( WikiaView $view ) {
		$this->view = $view;
		$this->view->setResponse( $this );
	}

	/**
	 * gets requested skin name
	 * @return String
	 */
	public function getSkinName() {
		return $this->skinName;
	}

	/**
	 * sets requested skin name
	 * @param String $name
	 */
	public function setSkinName( $name ) {
		$this->skinName = $name;
	}

	/**
	 * gets the controller name
	 * @return string
	 */
	public function getControllerName() {
		return $this->controllerName;
	}

	/**
	 * sets the controller name
	 * @param string $value
	 */
	public function setControllerName( $value ) {
		$this->controllerName = $value;
	}

	/**
	 * gets method name
	 * @return string
	 */
	public function getMethodName() {
		return $this->methodName;
	}

	/**
	 * sets method name
	 * @param string $value
	 */
	public function setMethodName( $value ) {
		$this->methodName = $value;
	}

	/**
	 * gets response data
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * sets response data
	 * @param array $data
	 */
	public function setData( Array $data ) {
		$this->data = $data;
	}

	/**
	 * get response body
	 * @return string
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * sets response body
	 * @param string $value
	 */
	public function setBody( $value ) {
		$this->body = $value;
	}

	/**
	 * reset all response data
	 */
	public function resetData() {
		$this->data = array();
	}

	/**
	 * append something to response body
	 * @param string $value
	 */
	public function appendBody( $value ) {
		$this->body .= $value;
	}

	/**
	 * get response code
	 * @return int
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * set response code
	 * @param int $value
	 */
	public function setCode( $value ) {
		$this->code = $value;
	}

	/**
	 * get content type
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}

	/**
	 * set content type
	 * @param string $value
	 */
	public function setContentType( $value ) {
		$this->contentType = $value;
	}

	public function hasContentType() {
		return (bool) $this->contentType;
	}

	public function getFormat() {
		return $this->format;
	}

	public function setFormat( $value ) {
		$value = strtolower( $value );
		if ( in_array( $value, [ self::FORMAT_HTML, self::FORMAT_JSON, self::FORMAT_JSONP ] ) ) {
			$this->format = $value;
		} else {
			\Wikia\Logger\WikiaLogger::instance()->warning( 'Invalid format passed to WikiaResponse', [
				'format' => $value,
				'exception' => new Exception()
			] );
			$this->format = self::FORMAT_INVALID;
		}
	}

	public function getHeaders() {
		return $this->headers;
	}

	public function setHeader( $name, $value, $replace = true ) {
		if ( $replace ) {
			$this->removeHeader( $name );
		}

		$this->headers[] = array(
		 'name' => $name,
		 'value' => $value,
		 'replace' => $replace
		);
	}

	/**
	 * Sets caching policy
	 *
	 * This method needs to be called before WikiaResponse::setCacheValidity
	 *
	 * @param string $policy caching policy (either private or public)
	 */
	public function setCachePolicy( $policy ) {
		if ( !in_array( $policy, [
				self::CACHE_PRIVATE,
				self::CACHE_PUBLIC,
				self::CACHE_ANON_PUBLIC_USER_PRIVATE,
			] )
		) {
			\Wikia\Logger\WikiaLogger::instance()->error( 'Invalid cache policy provided', [
				'policy' => $policy,
				'exception' => new Exception(),
			] );
			return;
		}

		$this->cachingPolicy = $policy;
	}

	/**
	 * Sets correct cache headers for the client, Varnish or both
	 *
	 * Cache-Control / X-Pass-Cache-Control headers will be set
	 *
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec13.html
	 *
	 * @param integer $varnishTTL expiry time for Varnish (and for the client if $browserTTL is not provided)
	 * @param bool|int $browserTTL expiry time for the client
	 */
	public function setCacheValidity( $varnishTTL, $browserTTL = false ) {
		$this->isCaching = true;

		// default to the TTL for Varnish
		if ($browserTTL === false) {
			$browserTTL = $varnishTTL;
		}
		$browserPolicy = self::CACHE_PUBLIC;

		switch($this->cachingPolicy) {
			case self::CACHE_PUBLIC:
			case self::CACHE_ANON_PUBLIC_USER_PRIVATE:
				$output = RequestContext::getMain()->getOutput();
				if ( $this->cachingPolicy === self::CACHE_ANON_PUBLIC_USER_PRIVATE &&
					$output->haveCacheVaryCookies()
				) {
					$this->setHeader( 'Cache-Control', 'private, s-maxage=0' );
					break;
				}

				// Varnish caches for 5 seconds when Apache sends Cache-Control: public, s-maxage=0
				// perform this logic here
				if ( $varnishTTL === self::CACHE_DISABLED ) {
					$varnishTTL = 5;
				}

				$this->setHeader('Cache-Control', sprintf('s-maxage=%d', $varnishTTL));
				break;

			case self::CACHE_PRIVATE:
				$browserPolicy = self::CACHE_PRIVATE;
				$this->setHeader( 'Cache-Control', 'private, s-maxage=0' );
				break;
		}

		// cache on client side
		if ($browserTTL > 0) {
			$this->setHeader( 'X-Pass-Cache-Control', sprintf( '%s, max-age=%d', $browserPolicy, $browserTTL ) );
		}
	}

	/**
	 * Tells you if the request has cache validity set
	 * @return bool
	 */
	public function isCaching() {
		return $this->isCaching;
	}

	public function getHeader( $name ) {
		$result = array();

		foreach ( $this->headers as $key => $header ) {
			if ( $header['name'] == $name ) {
				$result[] = $header;
			}
		}

		return ( count( $result ) ? $result : null );
	}

	public function removeHeader( $name ) {
		foreach ( $this->headers as $key => $header ) {
			if ( $header['name'] == $name ) {
				unset( $this->headers[ $key ] );
			}
		}
	}

	public function setVal( $key, $value ) {
		$this->data[$key] = $value;
	}

	/**
	 * Adds multiple values to the response object at once
	 *
	 * @param Array $values An hash with keys and related values, if the key is already
	 * set the value will be overwritten
	 *
	 * @author  Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function setValues( Array $values ) {
		$this->data = array_merge( $this->data, $values);
	}

	/* getVal can be called directly via $this->response->getVal()
	 * or by __get on WikiaDispatchable, which is frequently a "get" right before a "set"
	 * Returning a reference here allows us to use a pattern like:
	 * $this->foo = array();
	 * $this->foo['a'] = 'b';
	 * This style was valid in Oasis, not valid in Nirvana and now works again. BugId: 30231
	 */

	public function &getVal( $key, $default = null ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return $default;
	}

	public function unsetVal( $key ) {
		unset ( $this->data[$key] );
	}

	public function hasException() {
		return ( $this->exception == null ) ? false : true;
	}

	/**
	 * @return WikiaException|WikiaHttpException
	 */
	public function getException() {
		return $this->exception;
	}

	/**
	 * alias to be compatibile with MW AjaxDispatcher
	 * @return string
	 */
	public function printText() {
		print $this->toString();
	}

	public function render() {
		print $this->toString();
	}

	public function toString() {
		if ( $this->body === null ) {
			$this->body = $this->view->render();
		}
		return $this->body;
	}

	public function setTemplateEngine( $engine ) {
		if ( in_array( $engine, array(
				self::TEMPLATE_ENGINE_PHP,
				self::TEMPLATE_ENGINE_MUSTACHE)
		) ) {
			$this->templateEngine = $engine;
		}
	}

	public function getTemplateEngine() {
		return $this->templateEngine;
	}

	public function sendHeaders() {
		if ( !$this->hasContentType() ) {
			if ( ( $this->getFormat() === WikiaResponse::FORMAT_JSON ) ) {
				$this->setContentType( 'application/json; charset=utf-8' );
			} elseif ( $this->getFormat() === WikiaResponse::FORMAT_JSONP ) {
				$this->setContentType( 'text/javascript; charset=utf-8' );
			} elseif ( $this->getFormat() === WikiaResponse::FORMAT_HTML ) {
				$this->setContentType( 'text/html; charset=utf-8' );
			} elseif ( $this->getFormat() === WikiaResponse::FORMAT_INVALID ) {
				$this->setContentType( 'application/json; charset=utf-8' );
				$this->setCode( WikiaResponse::RESPONSE_CODE_BAD_REQUEST );
			}
		}

		foreach ( $this->getHeaders() as $header ) {
			$this->sendHeader( ( $header['name'] . ': ' . $header['value'] ), $header['replace']);
		}

		// Make sure we vary on Cookie if we have a different cache between anonymous
		// and logged-in users
		if ( $this->isCaching() &&
			$this->cachingPolicy === self::CACHE_ANON_PUBLIC_USER_PRIVATE
		) {
			$output = RequestContext::getMain()->getOutput();
			$this->sendHeader( $output->getVaryHeader(), true );
		}


		if ( !empty( $this->code ) ) {
			$msg = '';

			//standard HTTP response codes get automatically described by PHP and those descriptions shouldn't be overridden, ever
			//use a custom error code if you need a custom code description
			if ( !$this->isStandardHTTPCode( $this->code ) ) {
				if ( $this->hasException() ) {
					$msg = ' ' . $this->getException()->getMessage();
				}

				if ( empty($msg) ) {
					$msg = ' Unknown';
				}
			}

			$this->sendHeader( "HTTP/1.1 {$this->code}{$msg}", false );
		}

		if ( !empty( $this->contentType ) ) {
			$this->sendHeader( "Content-Type: " . $this->contentType, true );
		}
	}

	/**
	 * @brief redirects to another URL
	 *
	 * @param string $url the URL to redirect to
	 */
	public function redirect( $url ) {
		$this->sendHeader( "Location: " . $url, true );
	}

	/**
	 * @brief Add js var to script tag on top of the page
	 * THIS MUST BE CALLED BEFORE SKIN RENDERING
	 *
	 * @param string $name
	 * @param mixed $val
	 */
	public function setJsVar( $name, $val ) {
		//FIXME: is this global request context always valid? What about special pages?
		RequestContext::getMain()->getOutput()->addJsConfigVars($name, $val);
	}

	/**
	 * @desc Adds an asset to the current response
	 *
	 * @see Wikia::addAssetsToOutput
	 */
	public function addAsset( $assetName, $local = false ) {
		wfProfileIn( __METHOD__ );

		if ( $this->format == 'html' ) {
			Wikia::addAssetsToOutput( $assetName, $local );
		}

		wfProfileOut( __METHOD__ );
	}

	public function addModules( $modules ) {
		$app = F::app();
		$app->wg->Out->addModules($modules);
	}

	public function addModuleStyles( $modules ) {
		$app = F::app();
		$app->wg->Out->addModuleStyles($modules);
	}

	public function addModuleScripts( $modules ) {
		$app = F::app();
		$app->wg->Out->addModuleScripts($modules);
	}

	public function addModuleMessages( $modules ) {
		$app = F::app();
		$app->wg->Out->addModuleMessages($modules);
	}

	private function isStandardHTTPCode( $code ) {
		return in_array( $code, array(
			100, 101,
			200, 201, 202, 203, 204, 205, 206,
			300, 301, 302, 303, 304, 305, 306, 307,
			401, 402, 403, 404, 405, 406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 416, 417,
			500, 501, 502, 503, 504, 505
		) );
	}

	// @codeCoverageIgnoreStart
	protected function sendHeader( $header, $replace ) {
		if ( strpos( $header, "\n" ) !== false ) {
			\Wikia\Logger\WikiaLogger::instance()->warning( 'New line in header detected', [
				'header' => $header,
				'exception' => new Exception()
			] );
		}
		header( $header, $replace );
	}
	// @codeCoverageIgnoreEnd

	public function __toString() {
		try {
			return $this->toString();
		} catch ( Exception $e ) {
			// php doesn't allow exceptions to be thrown inside __toString() so we need an extra try/catch block here
			$app = F::app();
			$this->setException( $e );
			return $app->getView( 'WikiaError', 'error', array( 'response' => $this, 'devel' => $app->wg->DevelEnvironment ) )->render();
		}
	}

}
