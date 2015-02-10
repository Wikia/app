<?php

/**
 * UserLoginForm
 * @author Hyun
 * @author Saipetch
 *
 */
class UserLoginForm extends LoginForm {

	// CE-413 changed input names due to signup spam attack
	const SIGNUP_USERNAME_KEY = 'userloginext01';
	const SIGNUP_PASSWORD_KEY = 'userloginext02';

	var $msg = '';
	var $msgType = '';
	var $errParam = '';
	var $mExtUser;

	function load() {
		parent::load();
		$request = $this->mOverrideRequest;

		if ( $request->getText( self::SIGNUP_USERNAME_KEY, '' ) != '' ) {
			$this->mUsername = $request->getText( self::SIGNUP_USERNAME_KEY, '' );
		}
		if ( $request->getText( self::SIGNUP_PASSWORD_KEY, '' ) != '' ) {
			$this->mPassword = $request->getText( self::SIGNUP_PASSWORD_KEY );
			$this->mRetype = $request->getText( self::SIGNUP_PASSWORD_KEY );
		}

		// fake (decoy) username and password fields
		if ( $request->getText( 'username', '' ) != '' ) {
			$this->fakeUsername = $request->getText( 'username', '' );
		}
		if ( $request->getText( 'password', '' ) != '' ) {
			$this->fakePassword = $request->getText( 'password' );
		}

		if ( $request->getText( 'email', '' ) != '' ) {
			$this->mEmail = $request->getText( 'email' );
		}
		if ( $request->getVal( 'birthyear', '' ) != '' ) {
			$this->wpBirthYear = $request->getVal( 'birthyear' );
		}
		if ( $request->getVal( 'birthmonth', '' ) != '' ) {
			$this->wpBirthMonth = $request->getVal( 'birthmonth' );
		}
		if ( $request->getVal( 'birthday', '' ) != '' ) {
			$this->wpBirthDay = $request->getVal( 'birthday' );
		}
		if ( $request->getVal( 'signupToken', '' ) != '' ) {
			$this->mToken = $request->getVal( 'signupToken' );
		}
		if ( $request->getVal( 'returnto', '' ) != '' ) {
			$this->mReturnTo = $request->getVal( 'returnto' );
		}

		$this->wpUserBirthDay = strtotime( $this->wpBirthYear . '-' . $this->wpBirthMonth . '-' . $this->wpBirthDay );
	}

	// add new account
	public function addNewAccount() {
		$u = $this->addNewAccountInternal();
		if( $u == null )
			return false;

		// send confirmation email
		$userLoginHelper = new UserLoginHelper();
		$result = $userLoginHelper->sendConfirmationEmail( $this->mUsername );
		$this->setValidationResponse( $result['msg'], $result['result'] );

		return $u;
	}

	// add new accout by proxy
	public function addNewAccountMailPassword() {
		$u = $this->addNewAccountInternal();
		if ($u == null) {
			return false;
		}

		// add log
		$userLoginHelper = (new UserLoginHelper);
		$userLoginHelper->addNewUserLogEntry( $u, true );

		// mail temporary password
		$emailTextTemplate = F::app()->renderView( "UserLogin", "GeneralMail", array('language' => $u->getOption('language'), 'type' => 'account-creation-email') );
		$result = $this->mailPasswordInternal( $u, false, 'usersignup-account-creation-email-subject', 'usersignup-account-creation-email-body', $emailTextTemplate );
		if( !$result->isGood() ) {
			$this->setValidationResponse( wfMessage( 'userlogin-error-mail-error', $result->getMessage() )->parse() );
			return false;
		} else {
			$this->setValidationResponse( wfMessage( 'usersignup-account-creation-email-sent', $this->mEmail, $this->mUsername )->parse(), 'success' );
			return $u;
		}
	}

	// initial validation for username
	public function initValidationUsername() {
		// check empty username
		if ( $this->mUsername == '' ) {
			$this->setValidationResponse(
				wfMessage( 'userlogin-error-noname' )->escaped(),
				'error',
				self::SIGNUP_USERNAME_KEY );
			return false;
		}

		// check username length
		if( !User::isNotMaxNameChars($this->mUsername) ) {
			global $wgWikiaMaxNameChars;
			$this->setValidationResponse(
				wfMessage( 'usersignup-error-username-length', $wgWikiaMaxNameChars )->escaped(),
				'error',
				self::SIGNUP_USERNAME_KEY );
			return false;
		}

		// check valid username
		if( !User::getCanonicalName( $this->mUsername, 'creatable' ) ) {
			$this->setValidationResponse(
				wfMessage( 'usersignup-error-symbols-in-username' )->escaped(),
				'error',
				self::SIGNUP_USERNAME_KEY
			);
			return false;
		}

		$app = F::app();
		$result = wfValidateUserName( $this->mUsername );

		if ( $result === true ) {
			$msgKey = '';
			if ( !wfRunHooks('cxValidateUserName', array($this->mUsername, &$msgKey)) ) {
				$result = $msgKey;
			}
		}

		if ( $result !== true ) {
			$msg = '';
			if ( $result == 'userlogin-bad-username-taken' ) {
				$msg = wfMessage('userlogin-error-userexists')->escaped();
			} else if ( $result == 'userlogin-bad-username-character' ) {
				$msg = wfMessage('usersignup-error-symbols-in-username')->escaped();
			} else if ( $result == 'userlogin-bad-username-length' ) {
				$msg = wfMessage('usersignup-error-username-length', $app->wg->WikiaMaxNameChars)->escaped();
			} else {
				$msg = $result;
			}

			$this->setValidationResponse( $msg, 'error', self::SIGNUP_USERNAME_KEY );
			return false;
		}

		return true;
	}

	/**
	 * Initial validation for password
	 * @todo Do this on the front end so we're not sending passwords back and forth.
	 * @return bool
	 */
	public function initValidationPassword() {
		// check empty password
		if ( $this->mPassword == '' ) {
			$this->setValidationResponse(
				wfMessage( 'userlogin-error-wrongpasswordempty' )->escaped(),
				'error',
				self::SIGNUP_PASSWORD_KEY );
			return false;
		}

		// check password length
		if( !User::isNotMaxNameChars( $this->mPassword ) ) {
			$this->setValidationResponse(
				wfMessage( 'usersignup-error-password-length' )->escaped(),
				'error',
				self::SIGNUP_PASSWORD_KEY );
			return false;
		}

		return true;
	}

	// initial validation for birthdate
	public function initValidationBirthdate() {
		// check birthday
		if ( $this->wpBirthYear == -1 || $this->wpBirthMonth == -1 || $this->wpBirthDay == -1 ) {
			$this->setValidationResponse( wfMessage( 'userlogin-error-userlogin-bad-birthday' )->escaped(), 'error', 'birthday' );
			return false;
		}

		// check valid age
		$userBirthDay = strtotime( $this->wpBirthYear . '-' . $this->wpBirthMonth . '-' . $this->wpBirthDay );
		if( $userBirthDay > strtotime('-13 years') ) {
			$this->setValidationResponse( wfMessage( 'userlogin-error-userlogin-unable-info' )->escaped(), 'error', 'birthday' );
			return false;
		}

		return true;
	}

	// initial validation for email
	public function initValidationEmail() {
		// check empty email
		if ( $this->mEmail == '') {
			$this->setValidationResponse( wfMessage( 'usersignup-error-empty-email' )->escaped(), 'error', 'email' );
			return false;
		}

		// check email format
		if( !Sanitizer::validateEmail( $this->mEmail ) ) {
			$this->setValidationResponse( wfMessage( 'userlogin-error-invalidemailaddress' )->escaped(), 'error', 'email' );
			return false;
		}

		return true;
	}

	/**
	 * Validates email in terms of maximum registrations per email limit
	 *
	 * @return bool
	 */
	public function initValidationRegsPerEmail() {
		$sEmail = $this->mEmail;
		$result = UserLoginHelper::withinEmailRegLimit( $sEmail );
		if (!$result) {
			$this->setValidationResponse( wfMessage( 'userlogin-error-userlogin-unable-info' )->escaped(), 'error', 'email' );
		}
		return $result;
	}

	public function addNewAccountInternal() {
		if (!$this->initValidationUsername()) {
			return false;
		}

		if (!$this->initValidationEmail()) {
			return false;
		}

		if (!$this->initValidationPassword()) {
			return false;
		}

		if (!$this->initValidationBirthdate()) {
			return false;
		}

		return parent::addNewAccountInternal();
	}

	/**
	 * Apply a validation message (defaults to error message) to this form instance
	 * @param $msg
	 * @param string $msgType
	 * @param string $errParam
	 */
	private function setValidationResponse( $msg, $msgType = 'error', $errParam='' ) {
		$this->msgType = $msgType;
		$this->msg = $msg;
		$this->errParam = $errParam;
	}

	public function initUser( $u, $autocreate, $skipConfirm = false ) {
		global $wgCityId;
		$u = parent::initUser( $u, $autocreate );

		/*
		 * Remove when SOC-217 ABTest is finished
		 */
		$isAllowRegisterUnconfirmed = $this->isAllowedRegisterUnconfirmed();
		/*
		 * end remove
		 */

		if ( $skipConfirm === false ) {
			/*
			 * Remove when SOC-217 ABTest is finished
			 */
			$u->setOption(
				UserLoginSpecialController::NOT_CONFIRMED_LOGIN_OPTION_NAME,
				$isAllowRegisterUnconfirmed
					? UserLoginSpecialController::NOT_CONFIRMED_LOGIN_ALLOWED
					: UserLoginSpecialController::NOT_CONFIRMED_LOGIN_NOT_ALLOWED
			);
			/*
			 * end remove
			 */

			//Set properties that will require user to confirm email after signup
			$u->setOption( UserLoginSpecialController::SIGNUP_REDIRECT_OPTION_NAME, $this->mReturnTo );
			$u->setOption( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, true );
			$u->setOption( UserLoginSpecialController::SIGNED_UP_ON_WIKI_OPTION_NAME, $wgCityId );
			$u->saveSettings();
			UserLoginHelper::setNotConfirmedUserSession( $u->getId() );
		}

		wfRunHooks( 'AddNewAccount', array( $u, false ) );

		/*
		 * Remove when SOC-217 ABTest is finished
		 */
		if ( $isAllowRegisterUnconfirmed ) {
			$u->setCookies();
		}
		/*
		 * end remove
		 */

		return $u;
	}

	public function userNotPrivilegedMessage() {
		$this->setValidationResponse( wfMessage( 'userlogin-error-user-not-allowed' )->escaped() );
	}

	public function userBlockedMessage(Block $block) {
		$this->setValidationResponse( wfMessage( 'userlogin-error-cantcreateaccount-text' )->escaped() );
	}

	public function throttleHit( $limit ) {
		$this->setValidationResponse( wfMessage( 'userlogin-error-acct_creation_throttle_hit', $limit )->parse() );
	}

	/**
	 * Checks whether some hidden fields of signup form remain empty
	 * fakeUsername hidden username field (should be empty)
	 * fakePassword hidden password field (should be empty)
	 * These fields should be empty otherwise it probably has been modified by a bot
	 * and signup process should be interrupted
	 * @return bool
	 */
	public function EmptySpamFields() {
		if( empty( $this->fakeUsername) && empty( $this->fakePassword ) ) {
			return true;
		}
		return false;
	}


	/*
	 * Remove when SOC-217 ABTest is finished
	 */
	/**
	 * Check if user is allowed to register account without email confirmation
	 *
	 * @return bool
	 */
	public function isAllowedRegisterUnconfirmed() {
		$registerUnconfirmedCookie = $this->getRequest()->getCookie( 'RegisterUnconfirmed' );

		if ( !empty( F::app()->wg->EnableRegisterUnconfirmed ) && !empty( $registerUnconfirmedCookie ) ) {
			return true;
		}
		return false;
	}
	/*
	 * end remove
	 */
}
