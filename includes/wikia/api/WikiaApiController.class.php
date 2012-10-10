<?php
/**
 * Base class for Wikia API modules based off the Nirvana framework
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

abstract class WikiaApiController extends WikiaController {
	//Major API version, this is global and is controlled directly
	//from this base class
	const MAJOR_VERSION = '1';

	//Minore API version, this is per-controller and can be
	//overridden in subclasses
	protected $minorVersion = '0';

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

	/**
	 * Returns the version of the API controller,
	 * should be used to genrated cache keys for API
	 * controller methods in order to be able to bust
	 * the cache when needed.
	 *
	 * Changing the MAJOR_VERSION constant would bust the
	 * cache of all the API Controllers while changing the
	 * minorVersion variable in a Controller would bust only
	 * its' specific cache
	 *
	 * @return string The module version
	 */
	protected function getVersion() {
		return self::MAJOR_VERSION . '.' . $this->minorVersion;
	}
}