<?php

/**
 * Chat configuration failover
 *
 * @author Tomek
 *
 */
class ChatfailoverSpecialController extends WikiaSpecialPageController {
	const CHATFAILOVER_RESTRICTION = 'chatfailover';
	const FAILOVER_SCSS_PATH = 'extensions/wikia/Chat2/css/ChatFailover.scss';
	const FAILOVER_JS_PATH = 'extensions/wikia/Chat2/js/controllers/ChatFailover.js';

	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'Chatfailover', self::CHATFAILOVER_RESTRICTION, false );
	}

	/**
	 * Controllers can all have an optional init method
	 */
	public function init() {
		JSMessages::enqueuePackage( Chat::CHAT, JSMessages::EXTERNAL );
		$this->response->addAsset( self::FAILOVER_SCSS_PATH );
		$this->response->addAsset( self::FAILOVER_JS_PATH );
	}

	/**
	 * @brief this is default method, which in this example just redirects to Hello method
	 * @details No parameters
	 *
	 */
	public function index() {
		ChatHelper::info( __METHOD__ . ': Method called' );
		if ( !$this->wg->User->isAllowed( self::CHATFAILOVER_RESTRICTION ) ) {
			$this->skipRendering();
			throw new PermissionsError( self::CHATFAILOVER_RESTRICTION );
		}

		$mode = (bool) ChatHelper::getMode();
		$modeString = $this->getChatModeFromBool( $mode );
		$this->wg->Out->setPageTitle( wfMsg( 'Chatfailover' ) );

		if ( $this->request->wasPosted() ) {
			$reason = $this->request->getVal( 'reason' );
			if ( !empty( $reason ) && $mode === ChatHelper::getMode() ) { // the mode didn't change
				$mode = !$mode;
				StaffLogger::log( 'chatfo', 'switch', $this->wg->User->getID(), $this->wg->User->getName(), $mode, $modeString, $reason );
				ChatHelper::changeMode( $mode );
			}
		}

		$this->response->setVal( 'serversList', ChatHelper::getServersList() );
		$this->response->setVal('mode', $modeString );
		$this->response->setVal( 'modeBool', $mode );
	}

	/**
	 * For boolean mode value return string describing this mode
	 *
	 * @param $mode boolean
	 * @return string
	 */
	private function getChatModeFromBool( $mode ) {
		return $mode ? 'regular' : 'failover';
	}
}
