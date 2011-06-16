<?php

/**
 * This controller is used to render JavaScript code with "external" messages
 */

class JSMessagesController extends WikiaController {

	// cache responses for a week
	const CACHE_TIME = 604800;

	/**
	 * @brief Set caching headers for both Varnish and browser
	 *
	 * @param integer $duration - cache duration (in seconds)
	 */
	private function setCacheDuration($duration) {
		// headers taken from AssetsManagerServer
		$this->response->setHeader('Expires', gmdate('D, d M Y H:i:s', time() + $duration) . 'GMT');
		$this->response->setHeader('Cache-Control', 'public, max-age=' . $duration);
		$this->response->setHeader('X-Pass-Cache-Control', 'public, max-age=' . $duration);
	}

	/**
	 * @brief This function gets messages from given list of packages
	 */
	public function getMessages() {
		// get list of requested packages
		$packages = explode(',', $this->request->getVal('packages'));

		// get messages from given packages
		$messages = F::build('JSMessages')->getPackages($packages);

		$this->setVal('messages', $messages);

		// this should be handled as JS script
		$this->response->setHeader('Content-type', 'application/javascript; charset=utf-8');

		// cache it well :)
		$this->setCacheDuration(self::CACHE_TIME);
	}
}