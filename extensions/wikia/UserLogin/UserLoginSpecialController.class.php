<?php

/**
 * UserLogin Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class UserLoginSpecialController extends WikiaSpecialPageController {

	/* @const NOT_CONFIRMED_SIGNUP_OPTION_NAME Name of user option saying that user hasn't confirmed email since sign up */
	const NOT_CONFIRMED_SIGNUP_OPTION_NAME = 'NotConfirmedSignup';

	/* @const SIGNUP_REDIRECT_OPTION_NAME Name of user option containing redirect path to return to after email confirmation */
	const SIGNUP_REDIRECT_OPTION_NAME = 'SignupRedirect';

	/* @const SIGNED_UP_ON_WIKI_OPTION_NAME Name of user option containing id of wiki where user signed up */
	const SIGNED_UP_ON_WIKI_OPTION_NAME = 'SignedUpOnWiki';

	/* @var UserLoginHelper $userLoginHelper */
	private $userLoginHelper = null;

	public function __construct() {
		parent::__construct( 'UserLogin', '', false );
	}

	public function init() {
		$this->userLoginHelper = new UserLoginHelper();
	}

	private function initializeTemplate() {
		// Load Facebook JS if extension is enabled and skin supports it
		if ( !empty( $this->wg->EnableFacebookClientExt ) && !$this->isMonobookOrUncyclo() ) {
			$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginFacebookPageInit.js' );
		}
		$this->response->addAsset( 'extensions/wikia/UserLogin/css/UserLogin.scss' );

		// Assets including 'wikiamobile' in the name will be included by AssetsManager when showing the mobile skin
		$this->response->addAsset( 'userlogin_js_wikiamobile' );

		if ( $this->wg->EnableFacebookClientExt ) {
			$this->response->addAsset( 'userlogin_facebook_js_wikiamobile' );
		}

		$this->response->addAsset( 'userlogin_scss_wikiamobile' );

		// hide things in the skin
		$this->wg->SuppressWikiHeader = false;
		$this->wg->SuppressPageHeader = false;
		$this->wg->SuppressFooter = false;
		$this->wg->SuppressAds = true;
		$this->wg->SuppressToolbar = true;

		$this->getOutput()->disallowUserJs(); // just in case...
	}

	private function isMonobookOrUncyclo() {
		$skin = $this->wg->User->getSkin();
		return ( $skin instanceof SkinMonoBook || $skin instanceof SkinUncyclopedia );
	}

	/**
	 * Route the view based on logged in status
	 */
	public function index() {
		if ( $this->wg->User->isLoggedIn() ) {
			$this->forward( __CLASS__, 'loggedIn' );
		} else {
			$this->forward( __CLASS__, 'loginForm' );
		}
	}

	private function redirectToMercury() {
		$out = $this->getOutput();
		$out->redirect( $this->getRedirectUrl() );
		$this->clearBodyAndSetMaxCache( $out );
	}

	/**
	 * @param OutputPage $out
	 */
	private function clearBodyAndSetMaxCache( OutputPage $out ) {
		$out->setArticleBodyOnly( true );
		$out->setSquidMaxage( WikiaResponse::CACHE_LONG );
	}

	/**
	 * @return string
	 */
	private function getRedirectUrl() {
		$redirectUrl =
			$this->getAuthenticationResource() . '?redirect=' .
			$this->userLoginHelper->getRedirectUrl();
		$contentLangCode = $this->app->wg->ContLang->getCode();
		if ( $contentLangCode !== 'en' ) {
			$redirectUrl .= '&uselang=' . $contentLangCode;
		}

		return $redirectUrl;
	}

	/**
	 * @return string
	 */
	private function getAuthenticationResource() {
		if ( $this->wg->request->getVal( 'type' ) == 'forgotPassword' ) {
			return '/forgot-password';
		} else {
			return '/signin';
		}
	}

	/**
	 * Shown for both Special:UserLogin and Special:UserSignup when visited logged in.
	 */
	public function loggedIn() {
		$this->redirectToMercury();
	}

	public function loginForm() {
		// process login
		if ( $this->wg->request->wasPosted() ) {

			$action = $this->request->getVal( 'action', null );

			if ( $this->app->checkSkin( 'wikiamobile' ) ) {
				$recoverParam = 'recover=1';
				$recover = ( $this->wg->request->getInt( 'recover' ) === 1 );
				$this->response->setVal( 'recoverLink', SpecialPage::getTitleFor( 'UserLogin' )->getLocalURL( $recoverParam ) );
				$this->response->setVal( 'recoverPassword', $recover );
				if ( $recover ) {
					// we use different AssetsManager packages for recover and login, so make sure the page URL is different to avoid Varnish clashes
					$this->formPostAction .= "?{$recoverParam}";
				}
				if ( !empty( $action ) && ( $action === wfMessage( 'resetpass_submit' )->escaped()  || $this->result == 'resetpass' ) ) {
					$this->overrideTemplate( 'WikiaMobileChangePassword' );
				} else {
					$this->overrideTemplate( 'WikiaMobileIndex' );
				}

				return true;
			}

			if ( $action === wfMessage( 'resetpass_submit' )->escaped() ) {
				// change password
				$username = $this->request->getVal( 'username', '' );
				$password = $this->request->getVal( 'password', '' );
				$returnTo = urldecode( $this->request->getVal( 'returnto', '' ) );
				$editToken = $this->wg->request->getVal( 'editToken', '' );
				$loginToken = $this->wg->Request->getVal( 'loginToken', '' );
				$params = [
					'username' => $username,
					'password' => $password,
					'newpassword' => $this->wg->request->getVal( 'newpassword' ),
					'retype' => $this->wg->request->getVal( 'retype' ),
					'editToken' => $editToken,
					'loginToken' => $loginToken,
					'cancel' => $this->wg->request->getVal( 'cancel', false ),
					'returnto' => $returnTo,
				];

				$response =
					$this->app->sendRequest( 'UserLoginSpecial', 'changePassword', $params );

				$this->result = $response->getVal( 'result', '' );
				$this->msg = $response->getVal( 'msg', null );

				$this->response->getView()->setTemplate( 'UserLoginSpecial', 'changePassword' );

				return true;
			}

			if ( $this->result === 'closurerequested' ) {
				$response =
					$this->app->sendRequest( 'UserLoginSpecial', 'getCloseAccountRedirectUrl' );
				$redirectUrl = $response->getVal( 'redirectUrl' );
				$this->wg->Out->redirect( $redirectUrl );

				return true;
			}
		}

		$this->redirectToMercury();
	}

	public function getUnconfirmedUserRedirectUrl() {
		$this->redirectToMercury();
	}

	public function getCloseAccountRedirectUrl() {
		$this->redirectUrl =
			SpecialPage::getTitleFor( 'CloseMyAccount', 'reactivate' )->getFullUrl();
	}

	public function modal() {
		$this->redirectToMercury();
	}

	/**
	 * @brief retrieves valid login token
	 */
	public function retrieveLoginToken() {
		$this->loginToken = UserLoginHelper::getLoginToken();
	}

	/**
	 * Logs in a user with given login name and password. If keeploggedin, sets a cookie.
	 *
	 * @requestParam string username
	 * @requestParam string password
	 * @requestParam string keeploggedin [true/false]
	 * @responseParam string result [ok/error/unconfirm/resetpass]
	 * @responseParam string msg - result message
	 * @responseParam string errParam - error param
	 */
	public function login() {
		$this->redirectToMercury();
	}

	/**
	 * @see SUS-24
	 * @throws BadRequestException
	 */
	public function checkWriteRequest() {
		if ( !$this->request->isInternal() ) {
			if ( !$this->request->wasPosted() ||
			     !Wikia\Security\Utils::matchToken( UserLoginHelper::getLoginToken(),
				     $this->wg->request->getVal( 'token' ) )
			) {
				throw new BadRequestException( 'Request must be POSTed and provide a valid login token.' );
			}
		}
	}

	/**
	 * change password
	 * @requestParam string username
	 * @requestParam string password
	 * @requestParam string newpassword
	 * @requestParam string retype
	 * @requestParam string cancel [true/false] - on POST
	 * @requestParam string keeploggedin [true/false] - on POST
	 * @requestParam string returnto - url to return to upon successful login
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result message
	 */
	public function changePassword() {
		$this->wg->Out->setPageTitle( wfMessage( 'userlogin-password-page-title' )->plain() );
		$this->response->setVal( 'pageHeading', wfMessage( 'resetpass' )->escaped() );
		$this->initializeTemplate();

		$username = $this->request->getVal( 'username', '' );
		$password = $this->request->getVal( 'password', '' );
		$newPassword = $this->request->getVal( 'newpassword', '' );
		$retype = $this->request->getVal( 'retype', '' );
		$loginToken = $this->request->getVal( 'loginToken', '' );
		$returnto = $this->request->getVal( 'returnto', '' );

		$this->response->setValues( [
			'username' => $username,
			'password' => $password,
			'newpassword' => $newPassword,
			'retype' => $retype,
			'editToken' => $this->wg->User->getEditToken(),
			'loginToken' => $loginToken,
			'returnto' => $returnto,
		] );

		// since we don't support ajax GET, use of this parameter simulates a get request
		// in reality, it is being posted
		$fakeGet = $this->request->getVal( 'fakeGet', '' );

		if ( $this->wg->request->wasPosted() && empty( $fakeGet ) ) {
			if ( !$this->wg->Auth->allowPasswordChange() ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'resetpass_forbidden' )->escaped();

				return;
			}

			if ( $this->request->getVal( 'cancel', false ) ) {
				$this->userLoginHelper->doRedirect();

				return;
			}

			if ( $this->wg->User->matchEditToken( $this->request->getVal( 'editToken' ) ) ) {

				if ( $this->wg->User->isAnon() &&
				     $loginToken !== UserLoginHelper::getLoginToken()
				) {
					$this->result = 'error';
					$this->msg = wfMessage( 'sessionfailure' )->escaped();

					return;
				}

				$user = User::newFromName( $username );

				if ( !$user || $user->isAnon() ) {
					$this->result = 'error';
					$this->msg = wfMessage( 'userlogin-error-nosuchuser' )->escaped();

					return;
				}

				if ( $newPassword !== $retype ) {
					$this->result = 'error';
					$this->msg = wfMessage( 'badretype' )->escaped();
					wfRunHooks( 'PrefsPasswordAudit', [ $user, $newPassword, 'badretype' ] );

					return;
				}

				// from attemptReset() in SpecialResetpass
				if ( !$user->checkPassword( $password )->success() ) {
					$this->result = 'error';
					$this->msg = wfMessage( 'userlogin-error-wrongpassword' )->escaped();
					wfRunHooks( 'PrefsPasswordAudit', [ $user, $newPassword, 'wrongpassword' ] );

					return;
				}

				$valid = $user->getPasswordValidity( $newPassword );
				if ( $valid !== true ) {
					$this->result = 'error';
					$this->msg = wfMessage( $valid, $this->wg->MinimalPasswordLength )->text();

					return;
				}

				$user->setPassword( $newPassword );
				wfRunHooks( 'PrefsPasswordAudit', [ $user, $newPassword, 'success' ] );
				$user->saveSettings();

				$this->result = 'ok';
				$this->msg = wfMessage( 'resetpass_success' )->escaped();

				$this->wg->request->setVal( 'password', $newPassword );
				$response = $this->app->sendRequest( 'UserLoginSpecial', 'login' );

				$result = $response->getVal( 'result', '' );

				if ( $result === 'closurerequested' ) {
					$response =
						$this->app->sendRequest( 'UserLoginSpecial', 'getCloseAccountRedirectUrl' );
					$redirectUrl = $response->getVal( 'redirectUrl' );
					$this->wg->Out->redirect( $redirectUrl );
				} else {
					$this->userLoginHelper->doRedirect();
				}
			}
		}
	}
}
