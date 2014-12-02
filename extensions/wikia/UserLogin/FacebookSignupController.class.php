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
		if ( F::app()->wg->EnableFacebookClientExt ) {
			$user = FacebookClient::getInstance()->getWikiaUser( $fbUserId );
		} else {
			$user = FBConnectDB::getUser( $fbUserId );
		}

		if ( ( $user instanceof User ) && ( $fbUserId !== 0 ) ) {
			$this->errorMsg = '';

			if ( $this->isAccountDisabled( $user ) ) {
				// User account was disabled, abort the login
				$this->loginAborted = true;
				$this->errorMsg = wfMessage( 'userlogin-error-edit-account-closed-flag' )->escaped();
			} elseif ( !wfRunHooks( 'FacebookUserLoginSuccess', [ $user, &$this->errorMsg ] ) ) {
				$this->loginAborted = true;
			} else {
				// account is connected - log the user in
				$user->setCookies();

				$this->loggedIn = true;
				$this->userName = $user->getName();
			}
		} else {
			$modal = $this->sendRequest('FacebookSignup', 'modal')->__toString();

			// no account connected - show FB sign up modal
			$this->title = wfMessage('usersignup-facebook-heading')->escaped();
			$this->modal = !empty($modal) ? $modal : wfMessage('usersignup-facebook-problem')->escaped();
			$this->cancelMsg = wfMessage('cancel')->escaped();
		}
	}

	/**
	 * Displays Facebook sign up modal (called by index method)
	 */
	public function modal() {
		$fbUserId = $this->getFacebookUserId();
		if ( empty( $fbUserId ) ) {
			$this->skipRendering();
			return false;
		}

		// get an email from Facebook API
		$resp = $this->sendRequest( 'FacebookSignup', 'getFacebookData', [
			'fbUserId' => $fbUserId,
		] );

		// BugId:24400
		$data = $resp->getData();
		if ( empty( $data ) ) {
			$this->skipRendering();
			return false;
		}

		// The new FB SDK doesn't define contact_email
		if ( $this->wg->EnableFacebookClientExt ) {
			$this->fbEmail = $resp->getVal( 'email', false );
		} else {
			$this->fbEmail = $resp->getVal( 'contact_email', false );
			$email = $resp->getVal( 'email', false );

			// check for proxy email
			if ( $this->fbEmail != $email ) {
				$this->fbEmail = wfMessage( 'usersignup-facebook-proxy-email' )->escaped();
			}
		}

		$returnTo = $this->wg->request->getVal( 'returnto' );
		$returnToQuery = $this->wg->request->getVal( 'returntoquery' );

		// Temporary code until we switch fully to FacebookClient
		if ( F::app()->wg->EnableFacebookClientExt ) {
			$returnToUrl = FacebookClient::getInstance()->getReturnToUrl( $returnTo, $returnToQuery );
		} else {
			$returnToUrl = FBConnect::getReturnToUrl( $returnTo, $returnToQuery );
		}

		$returnToParams = 'returnto=' . $returnTo;
		if ( $returnToQuery ) {
			$returnToParams .= '&returntoquery=' . htmlspecialchars( $returnToQuery );
		}

		// query string is neaded for redirects after Special:FacebookConnect
		$this->queryString = $returnToParams;
		// return to url is needed for modal signup completion
		$this->returnToUrl = $returnToUrl;

		$this->loginToken = UserLoginHelper::getSignupToken();

		$specialPage = $this->wg->EnableFacebookClientExt ? 'FacebookConnect' : 'Connect';
		$this->connectUrl = SpecialPage::getTitleFor( $specialPage )->getLocalUrl();
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

			// CONN-421 Auto confirm Facebook accounts' emails
			$user->confirmEmail();
			wfRunHooks( 'SignupConfirmEmailComplete', array( $user ) );

			// Add new user to log
			$userLoginHelper = new UserLoginHelper();
			$userLoginHelper->addNewUserLogEntry( $user );
		}
	}

	/**
	 * Handler for Facebook Login for already connected users
	 * TODO/FIXME error messages
	 *
	 * @return null
	 * @throws FacebookMapModelInvalidDataException
	 */
	public function login() {
		$wg = $this->wg;

		$wikiaUserName = $wg->Request->getText( 'username' );
		$wikiaPassword = $wg->Request->getText( 'password' );

		if ( !$wikiaUserName || !$wikiaPassword ) {
			$errorCode = $wikiaUserName ?
				'userlogin-error-wrongpasswordempty' :
				'userlogin-error-noname';

			$this->response->setData( [
				'result' => 'error',
				'message' => wfMessage( $errorCode )->escaped(),
			] );
			return;
		}

		$user = \User::newFromName( $wikiaUserName );
		if ( !$user || !$user->checkPassword( $wikiaPassword ) ) {
			$this->response->setData( [
				'result' => 'error',
				'message' => wfMessage( 'userlogin-error-wrongcredentials' )->escaped(),
			] );
			return;
		}

		// Log the user in with existing wikia account
		// Create the fb/Wikia user mapping if not already created

		$fbUserId = FacebookClient::getInstance()->getUserId();

		// Returns an existing mapping or attempts to create one
		$userMap = \FacebookMapModel::createUserMapping( $user->getId(), $fbUserId );

		if ( !$userMap ) {
			// TODO/FIXME: show proper error message @see UC-116
			if ( empty( $fbUserId ) ) {
				$errorMessage = 'There was a problem detecting your Facebook account; please login to Facebook and try again.';
			} else {
				$errorMessage = 'There was a problem connecting your Wikia account to Facebook.';
			}

			$this->response->setData(
				[
					'result' => 'error',
					'message' => $errorMessage,
				]
			);
			return;
		}

		// Setup the session as is done when a request first starts
		if ( !$wg->SessionStarted ) {
			wfSetupSession();
		}
		$user->setCookies();

		// Store the user in the global user object
		$wg->User = $user;

		\FacebookClientHelper::track( 'facebook-link-existing' );

		$this->response->setData( [
			'result' => 'ok',
			'message' => 'success',
		] );
	}

	/**
	 * Return Facebook account data like email, gender, real name
	 */
	public function getFacebookData() {
		$fbUserId = $this->request->getVal( 'fbUserId' );

		if ( $fbUserId > 0 ) {

			// Toggle on new/old FB client
			if ( F::app()->wg->EnableFacebookClientExt ) {
				$data = FacebookClient::getInstance()->getUserInfoAsArray( $fbUserId );
			} else {
				// call Facebook API
				$FBApi = new FBConnectAPI();
				$data  = $FBApi->getUserInfo( $this->fbUserId, array(
					'first_name',
					'name',
					'sex',
					'timezone',
					'locale',
					'username',
					'contact_email',
					'email',
				) );
			}

			// BugId:24400
			if ( !empty( $data ) ) {
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
		// Toggle on new/old FB client
		if ( F::app()->wg->EnableFacebookClientExt ) {
			return FacebookClient::getInstance()->getUserId();
		} else {
			$fbApi = new FBConnectAPI();

			return $fbApi->user();
		}
	}

	/**
	 * Check if account is disabled
	 *
	 * @param  User    $user User account
	 * @return boolean       true if the account is disabled,
	 *                       false otherwise
	 */
	private function isAccountDisabled( User $user ) {
		return $user->getBoolOption( 'disabled' ) || (
			defined( 'CLOSED_ACCOUNT_FLAG' ) &&
			$user->getRealName() == CLOSED_ACCOUNT_FLAG
		);
	}
}
