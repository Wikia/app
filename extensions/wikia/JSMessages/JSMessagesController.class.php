<?php

/**
 * This controller is used to render JavaScript code with "external" messages
 */

class JSMessagesController extends WikiaController {

	/** @var int CACHE_TIME Cache responses for a week */
	const CACHE_TIME = 604800;

	/**
	 * @brief This function gets messages from given list of packages
	 * @deprecated SUS-623: use ResourceLoader instead
	 */
	public function getMessages() {
		// get list of requested packages
		$packages = explode( ',', $this->request->getVal( 'packages' ) );

		// get messages from given packages
		$messages = JSMessages::getPackages( $packages );

		$this->response->setBody(
			Xml::encodeJsCall( 'mw.messages.set', [
				new XmlJsCode( json_encode( $messages ) )
			] )
		);

		// this should be handled as JS script
		$this->response->setHeader( 'Content-Type', 'text/javascript; charset=utf-8' );

		// cache it well :)
		if ( !$this->request->isInternal() ) {
			$this->response->setCacheValidity( self::CACHE_TIME );

			$this->response->setContentType( 'text/javascript; charset=utf-8' );
		}
	}
}
