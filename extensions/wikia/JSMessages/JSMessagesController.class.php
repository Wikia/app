<?php

/**
 * This controller is used to render JavaScript code with "external" messages
 */

class JSMessagesController extends WikiaController {

	// cache responses for a week
	private $cacheTTL = 604800;

	/**
	 * @brief This function gets messages from given list of packages
	 */
	public function getMessages() {
		// cache it well :)
		if ( !$this->request->isInternal() ) {
			$buster = JSMessagesHelper::getMessagesCacheBuster();

			$this->response->setHeader( 'Cache-Control', "private, max-age={$this->cacheTTL}" );
			$this->response->setHeader( 'ETag', "\"$buster\"" );

			$this->response->setContentType( 'text/javascript; charset=utf-8' );

			$ifNoneMatch = $this->getContext()->getRequest()->getHeader( 'If-None-Match' );

			if ( $ifNoneMatch && trim( $ifNoneMatch, '"' ) === $buster ) {
				$this->response->setCode( 304 );
				return;
			}
		}

		// get list of requested packages
		$packages = str_getcsv( $this->request->getVal( 'packages' ) );

		// get messages from given packages
		$messages = JSMessages::getPackages( $packages );

		$this->setVal( 'messages', $messages );
	}
}
