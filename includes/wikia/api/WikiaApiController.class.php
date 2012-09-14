<?php
/**
 * Base class for Wikia API modules based off the Nirvana framework
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

abstract class WikiaApiController extends WikiaController {
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