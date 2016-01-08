<?php

/**
 * API which allows you to add items to Special:Log
 *
 * This is basically HTTP interface to the these PHP methods:
 *
 * LogPage::__construct ($type, $rc=true, $udp= 'skipUDP')
 * LogPage::addEntry ($action, $target, $comment, $params=array(), $doer=null)
 *
 * @see https://www.mediawiki.org/wiki/Manual:LogPage.php
 * @see https://www.mediawiki.org/wiki/Manual:Log_actions
 */

class LogEventsApiController extends WikiaApiController {

	/**
	 * Add a new entry to logging table
	 *
	 * @throws BadRequestException
	 */
	public function add() {
		global $wgTheSchwartzSecretToken, $wgTitle, $wgUser;

		if ( !$this->request->wasPosted() ) {
			throw new BadRequestException( 'This request must be POSTed' );
		}

		if ( !Wikia\Security\Utils::matchToken( $wgTheSchwartzSecretToken, $this->request->getVal( 'token' ) ) ) {
			throw new BadRequestException( 'This request must provide a valid token' );
		}

		$type = $this->request->getVal( 'type' );
		$action = $this->request->getVal( 'action' );
		$comment = $this->request->getVal( 'comment' );
		$params = json_decode( $this->request->getVal( 'params', '[]' ) );

		// exceptions thrown by addEntry() will be handled by Nirvana API dispatcher
		$entry = new LogPage( $type );
		$id = $entry->addEntry( $action, $wgTitle, $comment, $params, $wgUser );

		$this->response->setCode( WikiaResponse::RESPONSE_CODE_CREATED );
		$this->response->setData( [ 'id' => $id ] );
	}
}
