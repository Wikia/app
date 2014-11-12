<?php

class FacebookClientController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function preferences() {
		$this->response->addAsset('facebook_client_preferences_scss');

		$this->isConnected = $this->getVal( 'isConnected', false );

		// Settings for a connected user
		$this->facebookDisconnectLink = wfMessage( 'fbconnect-disconnect-link' )->parse();
		$this->fbFromExist = F::app()->wg->User->getOption( 'fbFromExist' );

		// Settings for a user who is not connected yet
		$this->facebookConvertMessage = wfMessage( 'fbconnect-convert' )->plain();

		$this->facebookButton = F::app()->renderView('FacebookButton', 'index', [
			'class' => 'sso-login-facebook',
			'text' => wfMessage('fbconnect-wikia-signup-w-facebook')->escaped()
		]);
	}

	/**
	 * Disconnect the user from Facebook
	 *
	 * @requestParam user This is a user object.  Only works for internal calls
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
			$this->msg = wfMessage( 'fbconnect-unknown-error' )->text();
		}
	}

	/**
	 * Ajax endpoint for connecting a logged in Wikia user to a Facebook account.
	 * By the time they get here they should already have logged into Facebook and have a Facebook user ID.
	 *
	 * @throws FacebookMapModelInvalidDataException
	 */
	public function connectLoggedInUser() {
		$wg = F::app()->wg;

		$fb = FacebookClient::getInstance();
		$fbUserId = $fb->getUserId();

		// The user must be logged into Facebook and wikia
		if ( !$fbUserId || !$wg->User->isLoggedIn() ) {
			$this->status = 'error';
			return true;
		}

		$map = new FacebookMapModel();
		$map->relate( $wg->User->getId(), $fbUserId );
		$map->save();

		$this->status = 'ok';

		$this->track( 'facebook-link-existing' );
	}

	/**
	 * Track an event with a given label with user-sign-up category
	 * @param string $label
	 * @param string $action optional, 'submit' by default
	 */
	protected function track( $label, $action = 'submit' ) {
		\Track::event( 'trackingevent', [
			'ga_action' => $action,
			'ga_category' => 'user-sign-up',
			'ga_label' => $label,
			'beacon' => !empty( F::app()->wg->DevelEnvironment ) ? 'ThisIsFake' : wfGetBeaconId(),
		] );
	}
}
