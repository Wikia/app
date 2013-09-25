<?php

/**
 * UserLoginForm
 * @author Hyun
 * @author Saipetch
 *
 */
class UserLoginForm extends LoginForm {

	var $msg = '';
	var $msgType = '';
	var $errParam = '';
	var $mExtUser;

	function load() {
		parent::load();
		$request = $this->mOverrideRequest;
		if ( $request->getText( 'userloginext01', '' ) != '' ) {
			$this->mUsername = $request->getText( 'userloginext01', '' );
		}
		if ( $request->getText( 'userloginext02', '' ) != '' ) {
			$this->mPassword = $request->getText( 'userloginext02' );
			$this->mRetype = $request->getText( 'userloginext02' );
		}
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
		$result = $userLoginHelper->sendConfirmationEmail( $this->mUsername, $u );
		$this->mainLoginForm( $result['msg'], $result['result'] );

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
			$this->mainLoginForm( wfMessage( 'userlogin-error-mail-error', $result->getMessage() )->parse() );
			return false;
		} else {
			$this->mainLoginForm( wfMessage( 'usersignup-account-creation-email-sent', $this->mEmail, $this->mUsername )->parse(), 'success' );
			return $u;
		}
	}

	// initial validation for username
	public function initValidationUsername() {
		// check empty username
		if ( $this->mUsername == '' ) {
			$this->mainLoginForm( wfMessage( 'userlogin-error-noname' )->escaped(), 'error', 'username' );
			return false;
		}

		// check if exist in tempUser
		if ( UserLoginHelper::isTempUser( $this->mUsername ) && TempUser::getTempUserFromName( $this->mUsername ) ) {
			$this->mainLoginForm( wfMessage( 'userlogin-error-userexists' )->escaped(), 'error', 'username' );
			return false;
		}

		// check username length
		if( !User::isNotMaxNameChars($this->mUsername) ) {
			global $wgWikiaMaxNameChars;
			$this->mainLoginForm( wfMessage( 'usersignup-error-username-length', $wgWikiaMaxNameChars )->escaped(), 'error', 'username' );
			return false;
		}

		// check valid username
		if( !User::getCanonicalName( $this->mUsername, 'creatable' ) ) {
			$this->mainLoginForm( wfMessage( 'usersignup-error-symbols-in-username' )->escaped(), 'error', 'username' );
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

			$this->mainLoginForm( $msg, 'error', 'username' );
			return false;
		}

		return true;
	}

	// initial validation for password
	public function initValidationPassword() {
		// check empty password
		if ( $this->mPassword == '' ) {
			$this->mainLoginForm( wfMessage( 'userlogin-error-wrongpasswordempty' )->escaped(), 'error', 'password' );
			return false;
		}

		// check password length
		if( !User::isNotMaxNameChars($this->mPassword) ) {
			$this->mainLoginForm( wfMessage( 'usersignup-error-password-length' )->escaped(), 'error', 'password' );
			return false;
		}

		return true;
	}

	// initial validation for birthdate
	public function initValidationBirthdate() {
		// check birthday
		if ( $this->wpBirthYear == -1 || $this->wpBirthMonth == -1 || $this->wpBirthDay == -1 ) {
			$this->mainLoginForm( wfMessage( 'userlogin-error-userlogin-bad-birthday' )->escaped(), 'error', 'birthday' );
			return false;
		}

		// check valid age
		$userBirthDay = strtotime( $this->wpBirthYear . '-' . $this->wpBirthMonth . '-' . $this->wpBirthDay );
		if( $userBirthDay > strtotime('-13 years') ) {
			$this->mainLoginForm( wfMessage( 'userlogin-error-userlogin-unable-info' )->escaped(), 'error', 'birthday' );
			return false;
		}

		return true;
	}

	// initial validation for email
	public function initValidationEmail() {
		// check empty email
		if ( $this->mEmail == '') {
			$this->mainLoginForm( wfMessage( 'usersignup-error-empty-email' )->escaped(), 'error', 'email' );
			return false;
		}

		// check email format
		if( !Sanitizer::validateEmail( $this->mEmail ) ) {
			$this->mainLoginForm( wfMessage( 'userlogin-error-invalidemailaddress' )->escaped(), 'error', 'email' );
			return false;
		}

		return true;
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

	public function mainLoginForm( $msg, $msgtype = 'error', $errParam='' ) {
		$this->msgType = $msgtype;
		$this->msg = $msg;
		$this->errParam = $errParam;
	}

	public function initUser( $u, $autocreate, $skipConfirm = false ) {
		global $wgCityId;
		$u = parent::initUser( $u, $autocreate );

		if ( $skipConfirm === false ) {
			//Set properties that will require user to confirm email after signup
			$u->setOption( UserLoginSpecialController::SIGNUP_REDIRECT_OPTION_NAME, $this->mReturnTo );
			$u->setOption( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME, true );
			$u->setOption( UserLoginSpecialController::SIGNED_UP_ON_WIKI_OPTION_NAME, $wgCityId );
			$u->saveSettings();
			UserLoginHelper::setNotConfirmedUserSession( $u->getId() );
		}

		wfRunHooks( 'AddNewAccount', array( $u, false ) );

		return $u;
	}

	public function userNotPrivilegedMessage() {
		$this->mainLoginForm( wfMessage( 'userlogin-error-user-not-allowed' )->escaped() );
	}

	public function userBlockedMessage(Block $block) {
		$this->mainLoginForm( wfMessage( 'userlogin-error-cantcreateaccount-text' )->escaped() );
	}

	public function throttleHit( $limit ) {
		$this->mainLoginForm( wfMessage( 'userlogin-error-acct_creation_throttle_hit', $limit )->parse() );
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

}
