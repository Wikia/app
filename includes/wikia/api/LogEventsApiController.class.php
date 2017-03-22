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

	/** @var LogPage $logPage */
	private $logPage;

	/**
	 * @param LogPage $logPage
	 */
	public function __construct( LogPage $logPage = null ) {
		parent::__construct();
		$this->logPage = $logPage ?? new LogPage();
	}

	/**
	 * Add a new entry to logging table
	 *
	 * @requestParam string type Log type: one of '', 'block', 'protect', 'rights', 'delete', 'upload', 'move'
	 * @requestParam string action Log action: one of '', 'block', 'protect', 'rights', 'delete', 'upload', 'move', 'move_redir'
	 * @requestParam string comment Log comment
	 * @requestParam integer user_id user ID of user to be logged as action performer
	 * @requestParam boolean showInRc [optional] whether to show the new log entry in recent changes
	 * @requestParam string params JSON dict of params which will be passed to i18n functions
	 *
	 * @responseParam int id ID of newly created log entry
	 *
	 * @throws BadRequestException
	 */
	public function add() {
		if ( !$this->request->wasPosted() ) {
			throw new BadRequestException( 'This request must be POSTed' );
		}

		if ( !Wikia\Security\Utils::matchToken( $this->wg->TheSchwartzSecretToken, $this->request->getVal( 'token' ) ) ) {
			throw new BadRequestException( 'This request must provide a valid token' );
		}

		// Disable email notifications for this request
		$this->wg->DisableOldStyleEmail = true;

		$type = $this->request->getVal( 'type' );
		$action = $this->request->getVal( 'action' );
		$comment = $this->request->getVal( 'comment' );
		$user_id = $this->request->getVal( 'user_id' );
		$showInRc = $this->request->getBool( 'showInRc', true );

		$params = json_decode( $this->request->getVal( 'params', '[]' ) );
		$user = User::newFromId($user_id);

		// exceptions thrown by addEntry() will be handled by Nirvana API dispatcher
		$this->logPage->setType( $type );
		$this->logPage->setUpdateRecentChanges( $showInRc );
		$id = $this->logPage->addEntry( $action, $this->wg->Title, $comment, $params, $user );

		$this->response->setCode( WikiaResponse::RESPONSE_CODE_CREATED );
		$this->response->setData( [ 'id' => $id ] );
	}
}
