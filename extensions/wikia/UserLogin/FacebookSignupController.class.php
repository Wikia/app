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
			} elseif ( $this->isAccountUnconfirmed( $user ) ) {
				$this->unconfirmed = true;
				$this->userName = $user->getName();
				LoginForm::clearLoginToken();
				$userLoginHelper = new UserLoginHelper();
				$userLoginHelper->setNotConfirmedUserSession( $user->getId() );
				$userLoginHelper->clearPasswordThrottle( $this->userName );
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
	 * Check if account is disabled
	 * @param  User $user User account
	 * @return boolean true if the account is disabled, false otherwise
	 */
	private function isAccountDisabled( User $user ) {
		return $user->getBoolOption( 'disabled' ) || (
			defined( 'CLOSED_ACCOUNT_FLAG' ) &&
			$user->getRealName() == CLOSED_ACCOUNT_FLAG
		);
	}

	/**
	 * Check if account is unconfirmed. User confirms via an email we sent them.
	 * @param  User $user User account
	 * @return boolean true if the account is unconfirmed, false otherwise
	 */
	private function isAccountUnconfirmed( User $user ) {
		return $user->getOption( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME );
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

		$signupResponse = $this->app->sendRequest( 'FacebookSignup', 'createAccount' )->getData();

		switch ( $signupResponse['result'] ) {
			case 'ok':
				$this->result = 'ok';
				break;
			case 'unconfirm':
				$this->result = 'unconfirm';
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
		if ( session_id() == '' ) {
			wfSetupSession();
		}

		$signupForm = new UserLoginFacebookForm( $this->wg->request );
		$signupForm->load();
		$signupForm->addNewAccount();

		$result = ( $signupForm->msgType == 'error' ) ? 'error' : 'ok' ;
		if ( $result == 'ok' && !$signupForm->getHasConfirmedEmail() ) {
			$result = 'unconfirm'	;
		}

		$this->result = $result;
		$this->msg = $signupForm->msg;
		$this->errParam = $signupForm->errParam;
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
}
