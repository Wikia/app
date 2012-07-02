<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	// Eclipse helper - will be ignored in production
	require_once( 'ApiBase.php' );
}

/**
 * Unit to create accounts in the current wiki
 *
 * @ingroup API
 */
class ApiValidateSignup extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		$result = array();

		switch ( $params['field'] ) {
			case "username":
				$mUser = User::newFromName( $params['inputVal'], 'creatable' );
				if ( !is_object( $mUser ) ) {
					$result['result'] = wfMsg( 'signupapi-noname' );
					$result['icon'] = 'MW-Icon-AlertMark.png';
				}

				if ( 0 != $mUser->idForName() ) {
					$result['result'] = wfMsg( 'signupapi-userexists' );
					$result['icon'] = "MW-Icon-NoMark.png";
				} else {
					$result['result'] = wfMsg( 'signupapi-ok' );
					$result['icon'] = "MW-Icon-CheckMark.png";
				}
				break;

			case "email" :
				$valid = User::isValidEmailAddr( $params['inputVal'] );
				if ( $valid ) {
					 $result['result']= wfMsg( 'signupapi-ok' );
					 $result['icon'] = "MW-Icon-CheckMark.png";
				} else {
					$result['result']= wfMsg( 'signupapi-invalidemailaddress' );
					$result['icon'] = "MW-Icon-NoMark.png";
				}
				break;

			case "passwordlength" :
				global $wgMinimalPasswordLength;
				$result['result'] = $wgMinimalPasswordLength;
				break;

			default :
				ApiBase::dieDebug( __METHOD__, "Unhandled case value: {$params['field']}" );
		}

		$this->getResult()->addValue( null, 'signup', $result );
	}

	public function mustBePosted() {
		return false;
	}

	public function isReadMode() {
		return false;
	}

	public function getAllowedParams() {
		return array(
			'field' => null,
			'inputVal' => null,
			'password' => null,
			'retype' => null,
			'email' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'name' => 'Desired Username',
			'password' => 'Password',
			'retype' => 'Re-typed Password',
			'email' => 'Email ID(optional)',
		);
	}

	public function getDescription() {
		return array(
			'This module validates the parameters posted by the signup form.'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'WrongPassword', 'info' => 'Incorrect password entered. Please try again.' ),
			array( 'code' => 'ReadOnlyPage', 'info' => 'Accounts cannot be created with read-only permissions' ),
			array( 'code' => 'NoCookies', 'info' => 'The user account was not created, as we could not confirm its source. Ensure you have cookies enabled, reload this page and try again.' ),
			array( 'code' => 'NeedToken', 'info' => 'You need to resubmit your signup with the specified token' ),
			array( 'code' => 'WrongToken', 'info' => 'You specified an invalid token' ),
			array( 'code' => 'InsufficientPermission', 'info' => 'You do not have sufficient permissions to create account' ),
			array( 'code' => 'CreateBlocked', 'info' => 'You have been blocked from creating accounts' ),
			array( 'code' => 'IPBlocked', 'info' => 'Your IP is blocked from creating accounts' ),
			array( 'code' => 'NoName', 'info' => 'You have not set a valid name for the username parameter' ),
			array( 'code' => 'UserExists', 'info' => 'Username entered already in use. Please choose a different name.' ),
			array( 'code' => 'WrongRetype', 'info' => 'The passwords you entered do not match.' ),
			array( 'code' => 'InvalidPass', 'info' => 'You specified an invalid password' ),
			array( 'code' => 'NoEmail', 'info' => 'No e-mail address specified' ),
			array( 'code' => 'InvalidEmail', 'info' => 'You specified an invalid email address' ),
			array( 'code' => 'BlockedByHook', 'info' => 'A hook blocked account creation' ),
			array( 'code' => 'ExternalDBError', 'info' => 'There was either an authentication database error or you are not allowed to update your external account.' ),
			array( 'code' => 'Throttled', 'info' => 'You have tried creating accounts too many times in a short period' ),
		) );
	}

	public function getExamples() {
		return array(
			'api.php?action=validatesignup&field=username&name=username'
		);
	}

		public function getVersion() {
		return __CLASS__ . ': $Id: validateSignup.php 91472 2011-07-05 18:43:51Z akshay $';
	}

}
