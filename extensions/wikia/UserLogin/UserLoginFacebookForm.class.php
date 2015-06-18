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

	/**
	 * Try and get an email for the user from Facebook. If Facebook has an email for the user
	 * we don't have to confirm it, Facebook has done that for us. If Facebook doesn't have one,
	 * try and pull one from the form and make note that we'll have to confirm the user.
	 * @param WebRequest $request
	 * @return String
	 */
	private function getUserEmail( WebRequest $request ) {

		$userInfo = FacebookClient::getInstance()->getUserInfo();
		$userEmail = $userInfo->getProperty( 'email' );
		if ( empty( $userEmail ) ) {
			// Email didn't come from facebook, we have to confirm it ourselves
			$this->hasConfirmedEmail = false;
			$userEmail = $request->getVal( 'email', '' );
		}

		return $userEmail;
	}

	/**
	 * Create a new user account wrapping the code with method callWithCaptchaDisabled to disable
	 * captcha checking.
	 *
	 * @return User A new user object
	 */
	public function addNewAccount() {
		return UserLoginHelper::callWithCaptchaDisabled( function() {
			return $this->addNewAccountInternal();
		} );
	}

	/**
	 * Initialize the user object
	 *
	 * @param User $user
	 * @param bool $autocreate
	 * @return User
	 */
	public function initUser( User &$user, $autocreate ) {

		$ret = parent::initUser( $user, $autocreate, $this->hasConfirmedEmail );

		if ( $ret ) {

			$this->connectWithFacebook( $user );
			$this->saveUserGender( $user );

			if ( $this->hasConfirmedEmail ) {
				$this->confirmUser( $user );
				$user->setCookies();
				$this->addNewUserToLog( $user );
			} else {
				$this->sendConfirmationEmail( $user );
			}
		}

		return $ret;
	}

	/**
	 * Connects given Wikia account with FB account and sets FB feed preferences
	 * @param User $user Wikia account
	 * @return bool true on success
	 */
	private function connectWithFacebook( User $user ) {
		$fbId = FacebookClient::getInstance()->getUserId();

		$fbClientFactory = new \FacebookClientFactory();
		$status = $fbClientFactory->connectToFacebook( $user->getId(), $fbId );

		return $status->isGood();
	}

	/**
	 * Save a user's gender from facebook if one is available. Facebook will return the
	 * following values for a user's gender: 'male', 'female', null.
	 * @param User $user
	 */
	private function saveUserGender( User $user ) {
		$fbUserInfo = FacebookClient::getInstance()->getUserInfo();
		$gender = $fbUserInfo->getProperty( 'gender' );
		if ( !is_null( $gender ) ) {
			$user->setOption( 'gender', $gender );
			$user->saveSettings();
		}
	}

	/**
	 * Confirm the user and set their cookies. This is used when a user already has an
	 * email registered with Facebook.
	 * @param User $user
	 */
	private function confirmUser( User $user ) {
		$user->confirmEmail();
		wfRunHooks( 'SignupConfirmEmailComplete', [ $user ] );
		$user->saveSettings();
	}

	/**
	 * Adds new user to log
	 * @param User $user
	 */
	private function addNewUserToLog( User $user ) {
		$userLoginHelper = new UserLoginHelper();
		$userLoginHelper->addNewUserLogEntry( $user );
	}

	/**
	 * Send a confirmation email to the user. This is used when the user doesn't
	 * have an email registered with Facebook and provides us one in the signup form.
	 */
	private function sendConfirmationEmail() {
		$userLoginHelper = new UserLoginHelper();
		$userLoginHelper->sendConfirmationEmail( $this->mUsername );
	}

	/**
	 * Return whether the user is signing up using a confirmed email address
	 * (ie, one from facebook), or is providing us an email and therefore we
	 * have to confirm it.
	 * @return bool
	 */
	public function getHasConfirmedEmail() {
		return $this->hasConfirmedEmail;
	}
}
