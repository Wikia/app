<?php

/**
 * Controller performing sign-up using Facebook Connect feature
 *
 * @author macbre
 */
class FacebookSignupController extends WikiaController {

	/**
	 * This method is called when user successfully logins using FB credentials
	 *
	 * Facebook user ID is passed to our backend:
	 *  - if there's Wikia account connected, log the user in,
	 *  - if not, render sign up modal
	 */
	public function index() {
		$fbUserId = $this->getFacebookUserId();

		// try to get connected Wikia account
		$user = FBConnectDB::getUser($fbUserId);

		if ( ($user instanceof User) && ($fbUserId !== 0) ) {
			// account is connected - log the user in
			$user->setCookies();

			$this->loggedIn = true;
			$this->userName = $user->getName();
		}
		else {
			$modal = $this->sendRequest('FacebookSignup', 'modal')->__toString();

			// no account connected - show FB sign up modal
			$this->title = wfMsg('usersignup-facebook-heading');
			$this->modal = !empty($modal) ? $modal : wfMsg('usersignup-facebook-problem');
			$this->cancelMsg = wfMsg('cancel');
		}
	}

	/**
	 * Displays Facebook sign up modal (called by index method)
	 */
	public function modal() {
		// get an email from Facebook API
		$resp = $this->sendRequest('FacebookSignup', 'getFacebookData', array(
			'fbUserId' => $this->getFacebookUserId(),
		));

		// BugId:24400
		$data = $resp->getData();
		if (empty($data)) {
			$this->skipRendering();
			return false;
		}

		$this->fbEmail = $resp->getVal('contact_email', false);
		$email = $resp->getVal('email', false);
		// check for proxy email
		if ( $this->fbEmail != $email ) {
			$this->fbEmail = wfMsg( 'usersignup-facebook-proxy-email' );
		}

		$this->loginToken = UserLoginHelper::getSignupToken();

		$this->specialUserLoginUrl = SpecialPage::getTitleFor('UserLogin')->getLocalUrl();

		// FB feed option checkboxes
		$this->fbFeedOptions = FBConnectPushEvent::getPreferencesToggles();
	}

	/**
	 * Handle sign up requests from modal
	 */
	public function signup() {
		// add Facebook user ID to the request, so the login form logic can access it
		$this->wg->Request->setVal('fbuserid', $this->getFacebookUserId());

		// handle signup request
		$signupResponse = $this->app->sendRequest('FacebookSignup', 'createAccount')->getData();

		switch ($signupResponse['result']) {
			case 'ok':
				$this->result = 'ok';
				$this->location = $signupResponse['userPage'];
				break;

			case 'error':
			default:
				// pass errors to the frontend form
				$this->response->setData($signupResponse);
				break;
		}
	}

	/**
	 * Handle internal requests for creating Wikia accounts
	 */
	public function createAccount() {
		// Init session if necessary
		if (session_id() == '') {
			wfSetupSession();
		}

		$signupForm = new UserLoginFacebookForm( $this->wg->request );
		$signupForm->load();
		$user = $signupForm->addNewAccount();

		$this->result = ( $signupForm->msgType == 'error' ) ? $signupForm->msgType : 'ok' ;
		$this->msg = $signupForm->msg;
		$this->errParam = $signupForm->errParam;

		// pass an ID of created account for FBConnect feature
		if ($user instanceof User) {
			$this->userId = $user->getId();
			$this->userPage = $user->getUserPage()->getFullUrl();
		}
	}

	/**
	 * Return Facebook account data like email, gender, real name
	 */
	public function getFacebookData() {
		$fbUserId = intval($this->request->getVal('fbUserId'));

		if ($fbUserId > 0) {
			// call Facebook API
			$FBApi = new FBConnectAPI();
			$data = $FBApi->getUserInfo($this->fbUserId, array(
				'first_name',
				'name',
				'sex',
				'timezone',
				'locale',
				'username',
				'contact_email',
				'email',
			));

			// BugId:24400
			if (!empty($data)) {
				$this->response->setData($data);
			}
		}
	}

	/**
	 * Get Facebook account ID of currently logged-in user.
	 *
	 * If no user is logged in, then an ID of 0 is returned.
	 */
	private function getFacebookUserId() {
		$fbApi = new FBConnectAPI();
		return $fbApi->user();
	}
}