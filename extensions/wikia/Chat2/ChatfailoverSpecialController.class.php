<?php

/**
 * Chat configuration failover
 *
 * @author Tomek
 *
 */
class ChatfailoverSpecialController extends WikiaSpecialPageController {
	const CHATFAILOVER_RESTRICTION = 'chatfailover';

	public function __construct() {
		// standard SpecialPage constructor call
		parent::__construct( 'Chatfailover', self::CHATFAILOVER_RESTRICTION, false );
	}

	// Controllers can all have an optional init method
	// TODO: do not hardcode this paths!
	public function init() {
		JSMessages::enqueuePackage( 'Chat', JSMessages::EXTERNAL );
		$this->response->addAsset( 'extensions/wikia/Chat2/css/ChatFailover.scss' );
		$this->response->addAsset( 'extensions/wikia/Chat2/js/controllers/ChatFailover.js' );
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
		$this->wg->Out->setPageTitle( wfMsg( 'Chatfailover' ) );

		if ( $this->request->wasPosted() ) {
			$reason = $this->request->getVal( 'reason' );
			if ( !empty( $reason ) && $mode == ChatHelper::getMode() ) { // the mode didn't change
				$mode = !$mode;
				StaffLogger::log( "chatfo", "switch", $this->wg->User->getID(), $this->wg->User->getName(), $mode, $mode ? 'regular' : 'failover', $reason );
				ChatHelper::changeMode( $mode );
			}
		}

		$serversList = ChatHelper::getServersList();

		$formattedServersList = array_map(
			function ( $item ) {
				return $item[ 'host' ] . ':' . $item[ 'port' ];
			},
			$serversList
		);

		$this->response->setVal( "serversList", $formattedServersList );

		$this->response->setVal( "mode", $mode ? 'regular' : 'failover' );
		$this->response->setVal( "modeBool", $mode );
	}
}
