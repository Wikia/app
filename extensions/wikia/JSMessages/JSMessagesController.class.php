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
			$this->response->setCachePolicy( WikiaResponse::CACHE_PUBLIC );
			$this->response->setCacheValidity(self::CACHE_TIME);

			$this->response->setContentType('text/javascript; charset=utf-8');
		}
	}
}
