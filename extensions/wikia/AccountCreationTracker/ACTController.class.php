<?php

class AccountCreationTrackerController extends WikiaSpecialPageController {
	const TRACKING_COOKIE_NAME = 'ACT';
	const TRACKING_COOKIE_TTL = 365; // in days

	protected $tracker = null;

	public function __construct() {
		$this->tracker = F::build('AccountCreationTracker');

		parent::__construct( 'Tracker', 'Tracker', false );
	}

	public function index() {
		if( !$this->wg->User->isAllowed( 'accounttracker' ) ) ) {
			$this->displayRestrictionError($this->user);
			$this->skipRendering();
			return false;
		}

		$this->wg->Out->addScriptFile( $this->wg->ExtensionsPath . "/wikia/AccountCreationTracker/ACT.js" );

		$username = $this->getVal( 'username' );
		$accounts = array();

		if( !empty( $username ) ) {
			$user = User::newFromName( $username );
			$userId = $user->getId();

			if( !empty( $userId ) ) {
				$accounts = $this->tracker->getAccountsByUser( $user );
			}
			else {
				$this->setVal( 'usernameNotFound', true );
			}
		}

		$this->setVal( 'username', $username );
		$this->setVal( 'accounts', $accounts );
	}

	public function onAddNewAccount( $user, $byEmail ) {
		if(!($this->request instanceof WikiaRequest)) {
			$this->setRequest( F::build('WikiaRequest', array( 'params' => array( $_POST, $_GET ) ) ) );
		}

		$hash = $this->request->getCookie( self::TRACKING_COOKIE_NAME );
		if( empty( $hash ) ) {
			$wgDevelEnvironment = F::app()->getGlobal( 'wgDevelEnvironment' );
			if( !empty( $wgDevelEnvironment ) ) {
				$domain = '.wikia-dev.com';
			}
			else {
				$domain = '.wikia.com';
			}

			$hash = md5( $user->getId() );
			$this->request->setCookie( self::TRACKING_COOKIE_NAME, $hash, ( time() + ( self::TRACKING_COOKIE_TTL * 86400 ) ), '/', $domain );
		}

		$this->tracker->trackAccount( $user, $hash );

		return true;
	}

}
