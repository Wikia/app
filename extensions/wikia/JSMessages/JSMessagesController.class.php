<?php

/**
 * This controller is used to render JavaScript code with "external" messages
 */

class JSMessagesController extends WikiaController {

	// cache responses for a week
	const CACHE_TIME = 604800;

	/**
	 * @brief This function gets messages from given list of packages
	 */
	public function getMessages() {
		// get list of requested packages
		$packages = explode(',', $this->request->getVal('packages'));

		// get messages from given packages
		$messages = JSMessages::getPackages($packages);

		$this->setVal('messages', $messages);

		// this should be handled as JS script
		$this->response->setHeader('Content-type', 'application/javascript; charset=utf-8');

		// cache it well :)
		if ( !$this->request->isInternal() ) {
			$this->response->setCacheValidity(self::CACHE_TIME, self::CACHE_TIME, array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			));

			$this->response->setContentType('text/javascript; charset=utf-8');
		}
	}
}