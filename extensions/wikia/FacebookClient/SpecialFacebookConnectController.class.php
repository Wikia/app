<?php

/**
 * Class SpecialFacebookConnectController
 *
 * This controller handles the Special:FacebookConnect page, which handles associating a FB user ID with
 * a Wikia user ID.
 */
class SpecialFacebookConnectController extends WikiaSpecialPageController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/** @var \FacebookClientFactory */
	protected $fbClientFactory;

	public function __construct() {
		parent::__construct( 'FacebookConnect', '', false );

		$this->fbClientFactory = new \FacebookClientFactory();
	}

	/**
	 * Handle hitting this page for the first time or after a POST of the login form
	 *
	 * @requestParam wpCancel
	 */
	public function index() {
		$wg = $this->wg;

		if ( $wg->Request->wasPosted() ) {
			if ( $wg->Request->getCheck( 'wpCancel' ) ) {
				$this->forward( __CLASS__, 'cancelConnect' );
			} else {
				$this->loginAndConnect();
			}
		} else if ( $wg->User->isLoggedIn() ) {
			// Send logged-in user to home page
			$wg->Out->redirect( '/' );
		} else {
			JSMessages::enqueuePackage( 'FacebookClient', JSMessages::INLINE );
			$this->forward( __CLASS__, 'connectUser' );
		}
	}

	/**
	 * Run when the user has clicked the 'cancel' button on the login form
	 */
	public function cancelConnect() {
		FacebookClient::getInstance()->logout();
		F::app()->wg->Out->showErrorPage(
			'fbconnect-cancel',
			'fbconnect-canceltext'
		);
		$this->skipRendering();
	}

	/**
	 * Run when the user has clicked the 'login' button on the login form
	 *
	 * @return bool
	 * @throws FacebookMapModelInvalidDataException
	 */
	protected function loginAndConnect() {
		$wg = $this->wg;

		$fb = FacebookClient::getInstance();
		$fbUserId = $fb->getUserId();

		$wikiaUserName = $wg->Request->getText( 'wpExistingName' );
		$wikiaPassword = $wg->Request->getText( 'wpExistingPassword' );

		// The user must be logged into Facebook before choosing a wiki username
		if ( empty( $fbUserId ) ) {
			$wg->Out->showErrorPage( 'fbconnect-error', 'fbconnect-errortext' );
			$this->skipRendering();
			return true;
		}

		$user = User::newFromName( $wikiaUserName );
		if ( !$user || !$user->checkPassword( $wikiaPassword ) ) {
			$wg->Request->setVal( 'errorMessage', 'fbconnect-wrong-pass-msg' );
			$this->forward( __CLASS__, 'connectUser' );
			return true;
		}

		// Create user mapping
		$status = $this->fbClientFactory->connectToFacebook( $wg->User->getId(), $fbUserId );
		if ( ! $status->isGood() ) {
			$this->showErrorPage( $status );
			$this->skipRendering();
			return true;
		}

		// Setup the session as is done when a request first starts
		if ( !$wg->SessionStarted ) {
			wfSetupSession();
		}
		$user->setCookies();

		// Store the user in the global user object
		$wg->User = $user;

		$this->forward( __CLASS__, 'successfulConnect' );

		\FacebookClientHelper::track( 'facebook-link-existing' );
	}

	/**
	 * Connect the already logged in Wikia user to a Facebook account.  By the time they get here
	 * they should already have logged into Facebook and have a Facebook user ID.
	 *
	 * @throws FacebookMapModelInvalidDataException
	 */
	public function connectCurrentUser() {
		$wg = $this->wg;

		$fb = FacebookClient::getInstance();
		$fbUserId = $fb->getUserId();

		// The user must be logged into Facebook.
		if ( !$fbUserId ) {
			$wg->Out->showErrorPage( 'fbconnect-error', 'fbconnect-errortext' );
			$this->skipRendering();
			return true;
		}

		// Create user mapping
		$status = $this->fbClientFactory->connectToFacebook( $wg->User->getId(), $fbUserId );
		if ( ! $status->isGood() ) {
			$this->showErrorPage( $status );
			$this->skipRendering();
			return true;
		}

		$this->forward( __CLASS__, 'successfulConnect' );

		\FacebookClientHelper::track( 'facebook-link-existing' );
	}

	/**
	 * This code is run when the user first reaches the Special:FacebookConnect page.  It displays
	 * a login form.  Successful login will connect that user to their Facebook account.
	 *
	 * @throws MWException
	 * @throws ReadOnlyError
	 */
	public function connectUser() {
		$wg = $this->wg;

		$title = wfMessage('fbconnect-connect-existing')->plain();
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
		$this->legendText = wfMessage( 'fbconnect-connect-login-legend' )->text();

		$this->userNameLabel = wfMessage( 'fbconnect-connect-username-label' )->plain();
		$this->userName = $userName;
		$this->passwordLabel = wfMessage( 'fbconnect-connect-password-label' )->plain();

		$this->returnTo = htmlspecialchars( $wg->request->getVal( 'returnto' ) );
		$this->returnToQuery = htmlspecialchars( $wg->request->getVal( 'returntoquery' ) );
	}

	/**
	 * Run when the user has successfully logged in from the login form
	 *
	 * @throws MWException
	 */
	public function successfulConnect() {
		$wg = $this->wg;

		// Set this so we have something to pass the hook, though its not used since we always
		// redirect at the end of this method.
		// @TODO Can we pass an empty string here and not define this unused variable?
		$inject_html = '';

		// Pull this into a separate variable so we can assign it back afterward
		$user = $wg->User;
		wfRunHooks( 'UserLoginComplete', [ &$user, &$inject_html ] );
		$wg->User = $user;

		$userLoginHelper = new UserLoginHelper();
		$returnToUrl = $userLoginHelper->getRedirectUrl( 'fbconnected=1' );

		$wg->Out->redirect( $returnToUrl );
	}

	/**
	 * An AJAX call to determine if the current user can connect to a Facebook account
	 *
	 * @return bool
	 * @throws MWException
	 */
	public function checkCreateAccount() {
		$wg = $this->wg;

		$fb = FacebookClient::getInstance();
		$fb_user = $fb->getUserId();

		// Set default status of 'error'
		$this->status = 'error';

		// Error out if there's no facebook user
		if ( empty( $fb_user ) ) {
			return true;
		}

		// Error out if there's a user ID defined (we're looking to connect an account)
		if ( $wg->User->getId() != 0 ) {
			return true;
		}

		// Error out if there is a Wikia user connected to this FB user (again, looking to connect an account)
		if ( $fb->getWikiaUser( $fb_user ) != null) {
			return true;
		}

		// Don't do anything when we're readonly
		if ( wfReadOnly() ) {
			return true;
		}

		// Block those who shouldn't be creating acounts
		if ( $wg->User->isBlockedFromCreateAccount() ) {
			return true;
		}

		// Look for any other errors around creating accounts
		$titleObj = SpecialPage::getTitleFor( 'FacebookConnect' );
		if ( count( $titleObj->getUserPermissionsErrors( 'createaccount', $wg->User, true ) ) > 0 ) {
			return true;
		}

		// If we get here, we're good
		$this->status = 'ok';
	}

	/**
	 * Displays an error page with error messages in status
	 * Wraps the OutputPage class
	 * @param Status $status
	 */
	protected function showErrorPage( \Status $status ) {
		if ( ! $status->isGood() ) {
			$errors = $status->getErrorsByType( 'error' );
			if ( ! empty( $errors[0]['message'] ) ) {
				$message = $errors[0]['message'];
				$params = $errors[0]['params'];
			} else {
				$message = 'fbconnect-error';
				$params = [];
			}
			F::app()->wg->Out->showErrorPage( 'fbconnect-error', $message, $params );
		}
	}
}
