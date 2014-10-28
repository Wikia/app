<?php

class FacebookClientController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 *
	 */
	public function index() {

	}

	public function preferences() {
		$this->isConnected = $this->getVal('isConnected', false);

		// Settings for a connected user
		$this->facebookDisconnectLink = wfMessage( 'facebookclient-disconnect-link' )->plain();
		$this->facebookDisconnectDone = wfMessage( 'facebookclient-disconnect-done' );
		$this->blankImgUrl = F::app()->wg->BlankImgUrl;

		if ( F::app()->wg->User->getOption( 'fbFromExist' ) ) {
			$this->facebookDisconnectInfo = wfMessage( 'facebookclient-disconnect-info-existing' );
		} else {
			$this->facebookDisconnectInfo = wfMessage( 'facebookclient-disconnect-info' );
		}

		// Settings for a user who is not connected yet
		$this->facebookConvertMessage = wfMessage('facebookclient-convert')->plain();
	}

	/**
	 * Disconnect the user from Facebook
	 *
	 * @requestParam user This is a user object.  Only works for internal callss
	 */
	public function disconnectFromFB() {
		$user = $this->getVal( 'user', null );

		if ( $user ) {
			$user = User::newFromId( $user );
		} else {
			$user = F::app()->wg->User;
		}

		FacebookMapModel::deleteFromWikiaID( $user->getId() );

		$params = new FauxRequest( [ 'wpName' => $user->getName() ] );
		$loginForm = new LoginForm( $params );

		if ( $user->getOption( 'fbFromExist' ) ) {
			$res = $loginForm->mailPasswordInternal( $user, true, 'fbconnect-passwordremindertitle-exist', 'fbconnect-passwordremindertext-exist' );
		} else {
			$res = $loginForm->mailPasswordInternal( $user, true, 'fbconnect-passwordremindertitle', 'fbconnect-passwordremindertext' );
		}

		if ( $res->isGood() ) {
			$this->status = 'ok';
		} else {
			$this->status = 'error';
			$this->msg = wfMessage( 'fbconnect-unknown-error' );
		}
	}
}
