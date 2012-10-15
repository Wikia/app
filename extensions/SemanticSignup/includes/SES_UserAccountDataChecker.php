<?php

/**
 * Created on 7 Jan 2008 by Serhii Kutnii
 */
class SES_UserAccountDataChecker extends SES_DataChecker {

	public $mUsername = '';
	public $mPassword = '';
	public $mEmail = '';
	public $mRealname = '';
	public $mDomain = '';
	public $mLanguage = '';
	public $mRemember = false;
	public $mUser = null;

	protected function populateData() {
		$this->mUsername = $this->getUserDataValue( 'wpName', 'nousername' );
		$name = trim( $this->mUsername );
		$this->mUser = User::newFromName( $name, 'creatable' );
		if ( !$this->mUser ) {
			$this->error( wfMsg( 'ses-noname' ) );
		}

		global $sesRealNameRequired;
		$this->mRealname = $this->getUserDataValue( 'wpRealName', $sesRealNameRequired ? 'norealname' : null );

		$this->mPassword = $this->getUserDataValue( 'wpPassword' );
		$retype = $this->getUserDataValue( 'wpRetype' );
		if ( strcmp( $this->mPassword, $retype ) )
			$this->error( wfMsg( 'ses-nopwdmatch' ) );

		$this->mDomain = $this->getUserDataValue( 'wpDomain' );

		global $wgEmailConfirmToEdit;
		$this->mEmail = $this->getUserDataValue( 'wpEmail', $wgEmailConfirmToEdit ? 'noemailtitle' : null );

		$this->mLanguage = $this->getUserDataValue( 'uselang' );

		global $wgRequest;
		$this->mRemember = $wgRequest->getCheck( 'wpRemember' );
	}

	// Checks

	public function checkDomainValidity()
	{
		global $wgAuth;

		if ( !$wgAuth->validDomain( $this->mDomain ) )
			$this->error( wfMsg( 'wrongpassword' ) );
	}

	public function checkDomainUser()
	{
		global $wgAuth;

		if ( ( 'local' != $this->mDomain ) && ( '' != $this->mDomain )
			&& !$wgAuth->canCreateAccounts() && ( !$wgAuth->userExists( $this->mName ) || !$wgAuth->authenticate( $this->mName, $this->mPassword ) ) )
				$this->error( wfMsg( 'wrongpassword' ) );
	}

	public function checkCreatePermissions()
	{
		global $wgUser;

		if ( !$wgUser->isAllowed( 'createaccount' ) || $wgUser->isBlockedFromCreateAccount() )
			$this->error( wfMsg( 'ses-createforbidden' ) );
	}

	public function checkSorbs()
	{
		global $wgProxyWhitelist;
		global $wgEnableSorbs, $wgRequest;
		$ip = $wgRequest->getIP();
		if ( $wgEnableSorbs && !in_array( $ip, $wgProxyWhitelist ) &&
		  $wgUser->inSorbsBlacklist( $ip ) )
		 	$this->error( wfMsg( 'sorbs_create_account_reason' ) );
	}

	public function checkUserExists()
	{
		if ( $this->mUser->idForName() )
			$this->error( wfMsg( 'ses-userexists' ) );
	}

	public function checkPasswordLength()
	{
		if ( !$this->mUser->isValidPassword( $this->mPassword ) )
		{
			global $wgMinimalPasswordLength;
			$this->error( wfMsgExt( 'passwordtooshort', array( 'parsemag' ), $wgMinimalPasswordLength ) );
		}
	}

	public function checkEmailValidity()
	{
		global $wgEnableEmail;
		if ( $wgEnableEmail && !User::isValidEmailAddr( $this->mEmail ) )
			$this->error( wfMsg( 'invalidemailaddress' ) );
	}

	public function __construct()
	{
		$this->addCheck( array( &$this, 'checkDomainValidity' ), array() );
		$this->addCheck( array( &$this, 'checkDomainUser' ), array() );
		$this->addCheck( array( &$this, 'checkCreatePermissions' ), array() );
		$this->addCheck( array( &$this, 'checkSorbs' ), array() );
		$this->addCheck( array( &$this, 'checkUserExists' ), array() );
		$this->addCheck( array( &$this, 'checkPasswordLength' ), array() );
		$this->addCheck( array( &$this, 'checkEmailValidity' ), array() );
	}
 }
