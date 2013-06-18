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
		if ( $request->getText( 'username', '' ) != '' ) {
			$this->mUsername = $request->getText( 'username', '' );
		}
		if ( $request->getText( 'password', '' ) != '' ) {
			$this->mPassword = $request->getText( 'password' );
			$this->mRetype = $request->getText( 'password' );
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

		// reset password
		$tempUser = TempUser::getTempUserFromName( $this->mUsername );
		$tempUser->setPassword('');
		$tempUser->updateData();
		$u = $tempUser->mapTempUserToUser( false, $u );

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
			$this->mainLoginForm( wfMsgExt( 'usersignup-account-creation-email-sent', array('parseinline'), $this->mEmail, $this->username ), 'success' );
			return $u;
		}
	}

	// initial validation for username
	public function initValidationUsername() {
		// check empty username
		if ( $this->mUsername == '' ) {
			$this->mainLoginForm( wfMsg( 'userlogin-error-noname' ), 'error', 'username' );
			return false;
		}

		// check if exist in tempUser
		if ( TempUser::getTempUserFromName( $this->mUsername ) ) {
			$this->mainLoginForm( wfMsg( 'userlogin-error-userexists' ), 'error', 'username' );
			return false;
		}

		// check username length
		if( !User::isNotMaxNameChars($this->mUsername) ) {
			global $wgWikiaMaxNameChars;
			$this->mainLoginForm( wfMsg( 'usersignup-error-username-length', $wgWikiaMaxNameChars ), 'error', 'username' );
			return false;
		}

		// check valid username
		if( !User::getCanonicalName( $this->mUsername, 'creatable' ) ) {
			$this->mainLoginForm( wfMsg( 'usersignup-error-symbols-in-username' ), 'error', 'username' );
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
				$msg = wfMsg('userlogin-error-userexists');
			} else if ( $result == 'userlogin-bad-username-character' ) {
				$msg = wfMsg('usersignup-error-symbols-in-username');
			} else if ( $result == 'userlogin-bad-username-length' ) {
				$msg = wfMsg('usersignup-error-username-length', $app->wg->WikiaMaxNameChars);
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
			$this->mainLoginForm( wfMsg( 'userlogin-error-wrongpasswordempty' ), 'error', 'password' );
			return false;
		}

		// check password length
		if( !User::isNotMaxNameChars($this->mPassword) ) {
			$this->mainLoginForm( wfMsg( 'usersignup-error-password-length' ), 'error', 'password' );
			return false;
		}

		return true;
	}

	// initial validation for birthdate
	public function initValidationBirthdate() {
		// check birthday
		if ( $this->wpBirthYear == -1 || $this->wpBirthMonth == -1 || $this->wpBirthDay == -1 ) {
			$this->mainLoginForm( wfMsg( 'userlogin-error-userlogin-bad-birthday' ), 'error', 'birthday' );
			return false;
		}

		// check valid age
		$userBirthDay = strtotime( $this->wpBirthYear . '-' . $this->wpBirthMonth . '-' . $this->wpBirthDay );
		if( $userBirthDay > strtotime('-13 years') ) {
			$this->mainLoginForm( wfMsg( 'userlogin-error-userlogin-unable-info' ), 'error', 'birthday' );
			return false;
		}

		return true;
	}

	// initial validation for email
	public function initValidationEmail() {
		// check empty email
		if ( $this->mEmail == '') {
			$this->mainLoginForm( wfMsg( 'usersignup-error-empty-email' ), 'error', 'email' );
			return false;
		}

		// check email format
		if( !Sanitizer::validateEmail( $this->mEmail ) ) {
			$this->mainLoginForm( wfMsg( 'userlogin-error-invalidemailaddress' ), 'error', 'email' );
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

	public function initUser( $u, $autocreate, $createTempUser = true ) {
		global $wgAuth, $wgExternalAuthType;

		// for FBconnect we don't want to create temp users
		if ($createTempUser === false) {
			return parent::initUser($u, $autocreate);
		}

		// add TempUser, update User object, set TempUser session
		$tempUser = TempUser::createNewFromUser( $u, $this->mReturnTo );

		if ( $wgExternalAuthType ) {
			$u = ExternalUser::addUser( $u, "", "", "" );
			if ( is_object( $u ) ) {
				$this->mExtUser = ExternalUser::newFromName( $this->mUsername );
			}
		} else {
			$u->addToDatabase();
		}
		$u->setToken();

		$wgAuth->initUser( $u, $autocreate );

		if ( is_object( $this->mExtUser ) ) {
			$this->mExtUser->linkToLocal( $u->getId() );
		}

		$u->setOption( 'rememberpassword', $this->mRemember ? 1 : 0 );
		if ( $this->mLanguage )
			$u->setOption( 'language', $this->mLanguage );
		$u->setOption('skinoverwrite', 1);

		$u->setPassword( $this->mPassword );
		$tempUser->setPassword( $u->mPassword );
		$tempUser->setId( $u->getId() );
		$tempUser->addToDatabase();

		wfRunHooks( 'AddNewAccountTempUser', array( $u, false ) );

		$tempUser->saveSettingsTempUserToUser( $u );
		$tempUser->setTempUserSession();

		return $u;
	}

	public function userNotPrivilegedMessage() {
		$this->mainLoginForm( wfMsg( 'userlogin-error-user-not-allowed' ) );
	}

	public function userBlockedMessage(Block $block) {
		$this->mainLoginForm( wfMsg( 'userlogin-error-cantcreateaccount-text' ) );
	}

	public function throttleHit( $limit ) {
		$this->mainLoginForm( wfMsgExt( 'userlogin-error-acct_creation_throttle_hit', array( 'parseinline' ), $limit ) );
	}

}
