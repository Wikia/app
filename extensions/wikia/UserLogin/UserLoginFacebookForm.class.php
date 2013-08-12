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
	private $fbFeedOptions;

	function __construct( WebRequest $request ) {
		$this->fbUserId = $request->getVal('fbuserid');
		$this->fbFeedOptions = explode(',', $request->getVal('fbfeedoptions', ''));

		// get an email from Facebook API
		$resp = F::app()->sendRequest('FacebookSignup', 'getFacebookData', array(
			'fbUserId' => $this->fbUserId,
		));

		// add an email to the request and pass it to the underlying class
		$request->setVal('email', $resp->getVal('email', false));
		if ( $request->getVal( 'type', '' ) == '' ) {
			$request->setVal( 'type', 'signup' );
		}

		parent::__construct( $request );
	}

	function addNewAccount() {
		// FIXME: an ugly hack to disable captcha checking
		global $wgCaptchaTriggers;

		$oldValue = $wgCaptchaTriggers;
		
		$wgCaptchaTriggers['createaccount'] = false;

		$ret = $this->addNewAccountInternal();

		// and bring back the old value
		$wgCaptchaTriggers = $oldValue;

		return $ret;
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
		FBConnectDB::addFacebookID($user, $this->fbUserId);

		foreach($this->fbFeedOptions as $feedName) {
			$optionName = "fbconnect-push-allow-{$feedName}";
			$user->setOption($optionName, 1);
		}
	}
}
