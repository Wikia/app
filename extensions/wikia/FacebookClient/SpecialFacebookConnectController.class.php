<?php

/**
 * Class SpecialFacebookConnectController
 *
 * This controller handles the Special:FacebookConnect page, which handles associating a FB user ID with
 * a Wikia user ID.
 */
class SpecialFacebookConnectController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'FacebookConnect', '', false );
	}

	/**
	 * Handle hitting this page for the first time or after a POST of the login form
	 *
	 * @requestParam wpCancel
	 */
	public function index() {
		$wg = F::app()->wg;

		if ( $wg->Request->wasPosted() ) {
			if ( $wg->Request->getCheck( 'wpCancel' ) ) {
				$this->cancelConnect();
			} else {
				$this->loginAndConnect();
			}
		} else {
			$this->forward( __CLASS__, 'connectExisting' );
		}
	}

	/**
	 * Run when the user has clicked the 'cancel' button on the login form
	 */
	protected function cancelConnect() {
		FacebookClient::getInstance()->logout();
		F::app()->wg->Out->showErrorPage(
			'facebookclient-connect-cancel',
			'facebookclient-connect-canceltext'
		);
	}

	/**
	 * Run when the user has clicked the 'login' button on the login form
	 *
	 * @return bool
	 * @throws FacebookMapModelInvalidDataException
	 */
	protected function loginAndConnect() {
		$wg = F::app()->wg;

		$fb = new FacebookClient();
		$fbUserId = $fb->getUserId();

		$wikiaUserName = $wg->Request->getText( 'wpExistingName' );
		$wikiaPassword = $wg->Request->getText( 'wpExistingPassword' );

		// The user must be logged into Facebook before choosing a wiki username
		if ( !$fbUserId ) {
			$wg->Out->showErrorPage( 'facebookclient-error', 'facebookclient-errortext' );
			wfProfileOut(__METHOD__);
			return true;
		}

		$user = User::newFromName( $wikiaUserName );
		if ( !$user || !$user->checkPassword( $wikiaPassword ) ) {
			$wg->Request->setVal( 'errorMessage', 'facebookconnect-wrong-pass-msg' );
			$this->forward( __CLASS__, 'connectExisting' );
			return true;
		}

		$map = new FacebookMapModel();
		$map->relate( $user->getId(), $fbUserId );
		$map->save();

		// Setup the session as is done when a request first starts
		if ( !$wg->SessionStarted ) {
			wfSetupSession();
		}
		$user->setCookies();

		// Store the user in the global user object
		$wg->User = $user;

		$this->forward( __CLASS__, 'successfulConnect' );

		$this->track( 'facebook-link-existing' );

		return true;
	}

	/**
	 * Run when the user has successfully logged in from the login form
	 *
	 * @throws MWException
	 */
	public function successfulConnect() {
		$wg = F::app()->wg;

		// Set this so we have something to pass the hook, though its not used since we always
		// redirect at the end of this method.
		// @TODO Can we pass an empty string here and not define this unused variable?
		$inject_html = '';

		// Pull this into a separate variable so we can assign it back afterward
		$user = $wg->User;
		wfRunHooks( 'UserLoginComplete', [ &$user, &$inject_html ] );
		$wg->User = $user;

		$titleObj = Title::newFromText( $this->mReturnTo );
		$queryStr = 'fbconnected=1&cb='.rand( 1, 10000 );

		if ( $this->isInvalidRedirectOnConnect( $titleObj ) ) {
			// Don't redirect if the location is no good.  Go to the main page instead
			$titleObj = Title::newMainPage();
		} else {
			// Include the return to query string if its ok to redirect
			$queryStr = $this->mReturnToQuery . '&' . $queryStr;
		}

		$wg->Out->redirect( $titleObj->getFullURL( $queryStr ) );
	}

	private function isInvalidRedirectOnConnect( $title ) {
		return (
			!$title instanceof Title ||
			$title->isSpecial( 'Userlogout' ) ||
			$title->isSpecial( 'Signup' ) ||
			$title->isSpecial( 'Connect' ) ||
			$title->isSpecial( 'FacebookConnect' )
		);
	}

	/**
	 * This code is run when the user first reaches the Special:FacebookConnect page.  It displays
	 * a login form.  Successful login will connect that user to their Facebook account.
	 *
	 * @throws MWException
	 * @throws ReadOnlyError
	 */
	public function connectExisting() {
		$wg = F::app()->wg;

		$title = wfMessage('facebookclient-connect-existing')->plain();
		$this->getContext()->getOutput()->setPageTitle( $title );

		$titleObj = SpecialPage::getTitleFor( 'FacebookConnect' );
		if ( wfReadOnly() ) {
			$wg->Out->readOnlyPage();
			return false;
		} elseif ( $wg->User->isBlockedFromCreateAccount() ) {
			// Add code to handle blocking here.

			// This was the old call and despite the comment, the method makes heavy use of $this
			//LoginForm::userBlockedMessage($wg->User->getBlock()); //this is not an explicitly static method but doesn't use $this and can be called like static (fixes RT#75589)
			return false;
		} elseif ( count( $permErrors = $titleObj->getUserPermissionsErrors( 'createaccount', $wg->User, true ) ) > 0 ) {
			$wg->Out->showPermissionsErrorPage( $permErrors, 'createaccount' );
			return false;
		}

		// Grab the UserName from the cookie if it exists
		$userNameCookie = $wg->CookiePrefix . 'UserName';
		$userName = isset( $_COOKIE[$userNameCookie] ) ? trim( $_COOKIE[$userNameCookie] ) : '';

		$errorMessage = $wg->Request->getVal( 'errorMessage' );

		if ( $errorMessage ) {
			$this->errorMessage = wfMessage( $errorMessage )->plain();
		}
		$this->formAction =  SpecialPage::getSafeTitleFor( 'FacebookConnect' )->getLocalURL();
		$this->legendText = wfMessage( 'facebookclient-connect-login-legend' );

		$this->userNameLabel = wfMessage( 'facebookclient-connect-username-label' )->plain();
		$this->userName = $userName;
		$this->passwordLabel = wfMessage( 'facebookclient-connect-password-label' )->plain();
	}

	/**
	 * Track an event with a given label with user-sign-up category
	 * @param string $label
	 * @param string $action optional, 'submit' by default
	 */
	protected function track( $label, $action = 'submit' ) {
		\Track::event( 'trackingevent', [
			'ga_action' => $action,
			'ga_category' => 'user-sign-up',
			'ga_label' => $label,
			'beacon' => !empty( F::app()->wg->DevelEnvironment ) ? 'ThisIsFake' : wfGetBeaconId(),
		] );
	}
}
