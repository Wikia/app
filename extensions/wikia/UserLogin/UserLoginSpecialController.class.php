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
		$loginTitle = SpecialPage::getTitleFor( 'UserLogin' );
		$this->formPostAction = $loginTitle->getLocalUrl();

		$skin = $this->wg->User->getSkin();
		$this->isMonobookOrUncyclo = ( $skin instanceof SkinMonoBook || $skin instanceof SkinUncyclopedia );
		$this->userLoginHelper = new UserLoginHelper();
	}

	private function initializeTemplate() {
		// Load Facebook JS if extension is enabled and skin supports it
		if ( !empty( $this->wg->EnableFacebookClientExt ) && !$this->isMonobookOrUncyclo ) {
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

	/**
	 * Route the view based on logged in status
	 */
	public function index() {
		$this->redirectToMercury();
	}

	private function redirectToMercury () {
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
		$redirectUrl = $this->getAuthenticationResource()
		               . '?redirect=' . $this->userLoginHelper->getRedirectUrl();
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
		$this->redirectToMercury();
	}

	public function getUnconfirmedUserRedirectUrl() {
		$this->redirectToMercury();
	}

	public function getCloseAccountRedirectUrl() {
		$this->redirectUrl = SpecialPage::getTitleFor( 'CloseMyAccount', 'reactivate' )->getFullUrl();
	}

	/**
	 * Renders html version that will be inserted into ajax based login interaction.
	 * On GET, template partial for an ajax element will render
	 */
	public function dropdown() {
		$query = $this->app->wg->Request->getValues();

		$this->response->setVal( 'returnto', $this->getReturnToFromQuery( $query ) );
		$this->response->setVal( 'returntoquery', $this->getReturnToQueryFromQuery( $query ) );

		$requestParams = $this->getRequest()->getParams();
		if ( !empty( $requestParams['registerLink'] ) ) {
			$this->response->setVal( 'registerLink',  $requestParams['registerLink'] );
		}

		if ( !empty( $requestParams['template'] ) ) {
			$this->overrideTemplate( $requestParams['template'] );
		}
	}

	public function getReturnToFromQuery( $query ) {
		if ( !is_array( $query ) ) {
			return '';
		}

		// If there's already a returnto here, use it.
		if ( isset( $query['returnto'] ) ) {
			return $query['returnto'];
		}

		if ( isset( $query['title'] ) && !$this->isTitleBlacklisted( $query['title'] ) ) {
			$returnTo = $query['title'];
		} else {
			$returnTo = $this->getMainPagePartialUrl();
		}

		return $returnTo;
	}

	private function getMainPagePartialUrl() {
		return Title::newMainPage()->getPartialURL();
	}

	private function isTitleBlacklisted( $title ) {
		return AccountNavigationController::isBlacklisted( $title );
	}

	private function getReturnToQueryFromQuery( $query ) {
		if ( !is_array( $query ) ) {
			return '';
		}

		if ( isset( $query['returnto'] ) ) {
			// If we're already got a 'returnto' value, make sure to pair it with the 'returntoquery' or
			// default to blank if there isn't one.
			return array_key_exists( 'returntoquery', $query ) ? $query['returntoquery'] : '';
		} elseif ( $this->request->wasPosted() ) {
			// Don't use any query parameters if this was a POST and we couldn't find
			// a returntoquery param
			return '';
		}

		// Ignore the title parameter as it would either be used by the returnto or blacklisted
		unset( $query['title'] );
		return wfArrayToCGI( $query );
	}

	public function providers() {
		$this->response->setVal( 'requestType',  $this->request->getVal( 'requestType', '' ) );

		// don't render FBconnect button when the extension is disabled
		if ( empty( $this->wg->EnableFacebookClientExt ) ) {
			$this->skipRendering();
		}

		$this->tabindex = $this->request->getVal( 'tabindex', null );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileProviders' );
		}
	}

	public function providersTop() {
		$this->response->setVal( 'requestType',  $this->request->getVal( 'requestType', '' ) );

		// don't render FBconnect button when the extension is disabled
		if ( empty( $this->wg->EnableFacebookClientExt ) ) {
			$this->skipRendering();
		}

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileProviders' );
		}
	}

	public function modal() {
		$this->response->setVal( 'loginToken', UserLoginHelper::getLoginToken() );
		$this->response->setVal( 'signupUrl', Title::newFromText( 'UserSignup', NS_SPECIAL )->getFullUrl() );
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
			if (!$this->request->wasPosted() || !Wikia\Security\Utils::matchToken(UserLoginHelper::getLoginToken(), $this->wg->request->getVal('token'))) {
				throw new BadRequestException('Request must be POSTed and provide a valid login token.');
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

				if ( $this->wg->User->isAnon()
					&& $loginToken !== UserLoginHelper::getLoginToken()
				) {
					$this->result = 'error';
					$this->msg = wfMessage( 'sessionfailure' )->escaped();
					return;
				}

				$user =  User::newFromName( $username );

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
					$response = $this->app->sendRequest( 'UserLoginSpecial', 'getCloseAccountRedirectUrl' );
					$redirectUrl = $response->getVal( 'redirectUrl' );
					$this->wg->Out->redirect( $redirectUrl );
				} else {
					$this->userLoginHelper->doRedirect();
				}
			}
		}
	}
}
