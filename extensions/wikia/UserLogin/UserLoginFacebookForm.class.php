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

	private $hasConfirmedEmail = true;

	function __construct( WebRequest $request ) {

		// put the username and password field in the expected place for validation MAIN-1283
		$request->setVal( 'userloginext01', $request->getVal( 'username' ) );
		$request->setVal( 'userloginext02', $request->getVal( 'password' ) );

		$request->setVal( 'email', $this->getUserEmail( $request ) );
		$request->setVal( 'type', 'signup' );

		parent::__construct( $request );
	}

	private function getUserEmail( WebRequest $request ) {

		$userInfo = FacebookClient::getInstance()->getUserInfo();
		$userEmail = $userInfo->getProperty( 'email' );
		if ( empty( $userEmail ) ) {
			// Email didn't come from facebook, we have to confirm it ourselves
			$this->hasConfirmedEmail = false;
			$userEmail = $request->getVal( 'email' );
		}

		return $userEmail;
	}

	function addNewAccount() {
		return UserLoginHelper::callWithCaptchaDisabled(function() {
			return $this->addNewAccountInternal();
		});
	}

	public function initUser( User $user, $autocreate ) {

		$user = parent::initUser( $user, $autocreate, $this->hasConfirmedEmail );

		if ( $user instanceof User ) {

			$this->connectWithFacebook($user);
			$user->saveSettings();

			if ( $this->hasConfirmedEmail ) {
				$this->confirmUser( $user );
			} else {
				$this->sendConfirmationEmail( $user );
			}
		}

		return $user;
	}

	private function confirmUser( User $user ) {
		$user->confirmEmail();
		$user->setCookies();
		wfRunHooks( 'SignupConfirmEmailComplete', array( $user ) );
		$userLoginHelper = new UserLoginHelper();
		$userLoginHelper->addNewUserLogEntry( $user ); // Add new user to log
	}

	private function sendConfirmationEmail() {
		$userLoginHelper = new UserLoginHelper();
		$result = $userLoginHelper->sendConfirmationEmail( $this->mUsername );
		$this->mainLoginForm( $result['msg'], $result['result'] );
	}

	/**
	 * Connects given Wikia account with FB account and sets FB feed preferences
	 *
	 * @param User $user Wikia account
	 * @return bool true on success
	 */
	private function connectWithFacebook( User $user ) {
		$fbId = FacebookClient::getInstance()->getUserId();

		if ( F::app()->wg->EnableFacebookClientExt ) {
			$mapping = \FacebookMapModel::createUserMapping( $user->getId(), $fbId );
			return !empty( $mapping );
		}

		FBConnectDB::addFacebookID( $user, $fbId );
		return true;
	}
}
