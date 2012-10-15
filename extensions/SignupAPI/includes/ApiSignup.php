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
class ApiSignup extends ApiBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		$params = $this->extractRequestParams();

		$result = array();

		$req = new FauxRequest( array(
			'wpName' => $params['name'],
			'wpPassword' => $params['password'],
			'wpRetype' => $params['retype'],
			'wpEmail'  => $params['email'],
			'wpDomain' => $params['domain'],
			'wpReason' => $params['realname'],
			'wpSourceAction' => $params['source_action'],
			'wpSourceNS' => $params['source_ns'],
			'wpSourceArticle' => $params['source_article'],
			'wpRemember' => ''
		) );

		// Init session if necessary
		if ( session_id() == '' ) {
			wfSetupSession();
		}

		$signupForm = new SpecialUserSignup( $req );

		global $wgCookiePrefix, $wgUser;

		$signupRes = $signupForm->addNewAccountInternal();
		switch( $signupRes ) {
			case SpecialUserSignup::SUCCESS:
				//$signupForm->initUser($signupForm->mUser);

				wfRunHooks( 'AddNewAccount', array( $wgUser, false ) );
				# Run any hooks; display injected HTML
				$injected_html = '';
				$welcome_creation_msg = 'welcomecreation';

				wfRunHooks( 'UserLoginComplete', array( &$wgUser, &$injected_html ) );

				//let any extensions change what message is shown
				wfRunHooks( 'BeforeWelcomeCreation', array( &$welcome_creation_msg, &$injected_html ) );

				$result['result'] = 'Success';
				$result['lguserid'] = intval( $wgUser->getId() );
				$result['lgusername'] = $wgUser->getName();
				$result['lgtoken'] = $wgUser->getToken();
				$result['cookieprefix'] = $wgCookiePrefix;
				$result['sessionid'] = session_id();
				break;

			case SpecialUserSignup::INVALID_DOMAIN:
				$result['result'] = 'WrongPassword';
				$result['domain']= $signupForm->mDomain;
				break;

			case SpecialUserSignup::READ_ONLY_PAGE:
				$result['result'] = 'ReadOnlyPage';
				break;

			case SpecialUserSignup::NO_COOKIES:
				$result['result'] = 'NoCookies';
				break;

			case SpecialUserSignup::NEED_TOKEN:
				$result['result'] = 'NeedToken';
				$result['token'] = $signupForm->getCreateaccountToken();
				$result['cookieprefix'] = $wgCookiePrefix;
				$result['sessionid'] = session_id();
				break;

			case SpecialUserSignup::WRONG_TOKEN:
				$result['result'] = 'WrongToken';
				break;

			case SpecialUserSignup::INSUFFICIENT_PERMISSION:
				$result['result'] = 'InsufficientPermission';
				break;

			case SpecialUserSignup::CREATE_BLOCKED:
				$result['result'] = 'CreateBlocked';
				break;

			case SpecialUserSignup::IP_BLOCKED:
				$result['result'] = 'IPBlocked';
				break;

			case SpecialUserSignup::NO_NAME:
				$result['result'] = 'NoName';
				break;

			case SpecialUserSignup::USER_EXISTS:
				$result['result'] = 'UserExists';
				break;

			case SpecialUserSignup::WRONG_RETYPE:
				$result['result'] = 'WrongRetype';
				break;

			case SpecialUserSignup::INVALID_PASS:
				$result['result'] = 'InvalidPass';
				break;

			case SpecialUserSignup::NO_EMAIL:
				$result['result'] = 'NoEmail';
				break;

			case SpecialUserSignup::INVALID_EMAIL:
				$result['result'] = 'InvalidEmail';
				break;

			case SpecialUserSignup::BLOCKED_BY_HOOK:
				$result['result'] = 'BlockedByHook';
				break;

			case SpecialUserSignup::EXTR_DB_ERROR:
				$result['result'] = 'ExternalDBError';
				break;

			case SpecialUserSignup::THROTLLED:
				$result['result'] = 'Throttled';
				break;

			default:
				ApiBase::dieDebug( __METHOD__, "Unhandled case value: {$signupRes}" );
		}

		$this->getResult()->addValue( null, 'signup', $result );
		}

	public function mustBePosted() {
		return true;
	}

	public function isReadMode() {
		return false;
	}

	public function getAllowedParams() {
		return array(
			'name' => null,
			'password' => null,
			'retype' => null,
			'email' => null,
			'domain' => null,
			'realname' => null,
			'source_action' => null,
			'source_ns' => null,
			'source_article' => null,
		);
	}

	public function getParamDescription() {
		return array(
			'name' => 'Desired Username',
			'password' => 'Password',
			'retype' => 'Re-typed Password',
			'email' => 'Email ID(optional)',
			'domain' => 'Domain (optional)',
			'realname' => 'Real Name(optional)',
			'source_action' => 'Source Action',
			'source_ns' => 'Source Namespace ID',
			'source_article' => 'Source Article ID',
		);
	}

	public function getDescription() {
		return array(
			'This module validates the parameters posted by the signup form.',
			'If validated, a new account is created for the user.',
			'If validation of any of the fields fails, the cause of',
			'the error will be output. If the user chooses to provide',
			'his email then a confirmation mail will be sent to him.',
			'On successful account creation, this module will call APILogin',
			'alongwith the newly created username & password'
		);
	}

	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
			array( 'code' => 'WrongPassword', 'info' => 'Incorrect password entered. Please try again.' ),
			array( 'code' => 'ReadOnlyPage', 'info' => 'Accounts cannot be created with read-only permissions' ),
			array( 'code' => 'NoCookies', 'info' => 'The user account was not created, as we could not confirm its source. ' .
				'Ensure you have cookies enabled, reload this page and try again.' ),
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
			'api.php?action=signup&username=username&password=password&retype=passretype'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiSignup.php 98229 2011-09-27 16:17:06Z reedy $';
	}

}

