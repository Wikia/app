<?php

/**
 * UserLoginFacebook
 *
 * Extends login form to provide FBconnect specific functionality:
 *  - don't create user account in temporary table
 *  - don't check captcha
 *  - confirm user email (fetched from Facebook API)
 *
 * @author Macbre
 *
 */

class UserLoginFacebookForm extends UserLoginForm {

	private $fbUserId;

	function __construct( WebRequest $request ) {
		$this->fbUserId = $request->getVal( 'fbuserid' );

		// See if we got an email address from the sign up form
		$userEmail = $request->getVal( 'email' );
		if ( empty( $userEmail ) ) {
			// If not, get an email from Facebook API
			$resp = F::app()->sendRequest( 'FacebookSignup', 'getFacebookData', [
				'fbUserId' => $this->fbUserId,
			] );
			$userEmail = $resp->getVal( 'email', false );
		}

		// add an email to the request and pass it to the underlying class
		$request->setVal( 'email', $userEmail );

		// put the username and password field in the expected place for validation MAIN-1283
		$request->setVal( 'userloginext01', $request->getVal( 'username' ) );
		$request->setVal( 'userloginext02', $request->getVal( 'password' ) );

		if ( $request->getVal( 'type', '' ) == '' ) {
			$request->setVal( 'type', 'signup' );
		}

		parent::__construct( $request );
	}

	function addNewAccount() {
		return UserLoginHelper::callWithCaptchaDisabled(function() {
			return $this->addNewAccountInternal();
		});
	}

	public function initUser( User $user, $autocreate ) {
		$user = parent::initUser($user, $autocreate, true );

		if ($user instanceof User) {
			$user->confirmEmail();
			$this->connectWithFacebook($user);
			$user->saveSettings();

			// log me in
			$user->setCookies();
		}

		return $user;
	}

	/**
	 * Connects given Wikia account with FB account and sets FB feed preferences
	 *
	 * @param User $user Wikia account
	 */
	private function connectWithFacebook(User $user) {
		if ( F::app()->wg->EnableFacebookClientExt ) {
			\FacebookClientHelper::createUserMapping( $user->getId(), $this->fbUserId );
		} else {
			FBConnectDB::addFacebookID( $user, $this->fbUserId );
		}
	}
}
