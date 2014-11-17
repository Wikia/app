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

	/* @var $userLoginHelper UserLoginHelper */
	private $userLoginHelper = null;

	// let's keep this fields private for security reasons
	private $username = '';
	private $password = '';

	public function __construct() {
		parent::__construct( 'UserLogin', '', false );
	}

	public function init() {
		$loginTitle = SpecialPage::getTitleFor( 'UserLogin' );
		$this->formPostAction = $loginTitle->getLocalUrl();
		$this->isMonobookOrUncyclo = ( $this->wg->User->getSkin() instanceof SkinMonoBook || $this->wg->User->getSkin() instanceof SkinUncyclopedia );
		$this->userLoginHelper = (new UserLoginHelper);
	}

	private function initializeTemplate() {
		//Oasis/Monobook, will be filtered in AssetsManager :)
		$this->response->addAsset( 'extensions/wikia/UserLogin/css/UserLogin.scss' );
		if ( !empty($this->wg->EnableFacebookConnectExt) ) {
			$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginFacebookPageInit.js' );
			$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginFacebook.js' );
		}

		$this->response->addAsset('extensions/wikia/UserLogin/js/UserLoginSpecial.js');
		$this->response->addAsset('extensions/wikia/WikiaStyleGuide/js/Form.js');

		//Wikiamobile, will be filtered in AssetsManager by config :)
		$this->response->addAsset(
				( $this->wg->request->getInt( 'recover' ) === 1 || empty( $this->wg->EnableFacebookConnectExt ) ) ?
					'userlogin_js_wikiamobile' :
					'userlogin_js_wikiamobile_fbconnect'
		);

		//Wikiamobile, will be filtered in AssetsManager by config :)
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
	 * @brief serves standalone login page on GET.  if POSTed, parameters will be required.
	 * @details
	 *   on GET, template will render
	 *   on POST,
	 *     if login is successful, it will redirect to returnto, or default login welcome screen
	 *     if login is not successful, the template will render will error messages, highlighting the errors
	 * @requestParam string username - on POST
	 * @requestParam string password - on POST
	 * @requestParam string keeploggedin [true/false] - on POST
	 * @requestParam string returnto - url to return to upon successful login
	 * @requestParam string loginToken
	 * @requestParam string action
	 * @responseParam string result [ok/error/unconfirm/resetpass]
	 * @responseParam string msg - result message
	 * @responseParam string errParam - error param
	 * @responseParam string editToken - token for changing password
	 */
	public function index() {
		$returnTo = urldecode( $this->request->getVal( 'returnto', '' ) );
		$returnToQuery = urldecode( $this->request->getVal( 'returntoquery', '' ) );

		// redirect if signup
		$type = $this->request->getVal('type', '');
		if ($type === 'signup' || $this->getPar() == 'signup') {
			$title = SpecialPage::getTitleFor( 'UserSignup' );
			$this->wg->Out->redirect( $title->getFullURL( [
				['returnto' => $returnTo],
				['returntoquery' => $returnToQuery],
			] ) );
			return false;
		}

		$this->initializeTemplate();

		// set page title
		$this->wg->Out->setPageTitle( wfMessage('userlogin-login-heading')->plain() );

		// params
		$this->username = $this->request->getVal( 'username', '' );
		$this->password = $this->request->getVal( 'password', '' );
		$this->keeploggedin = $this->request->getCheck( 'keeploggedin' );
		$this->loginToken = UserLoginHelper::getLoginToken();
		$this->returnto = $returnTo;
		$this->returntoquery = $returnToQuery;

		// process login
		if ( $this->wg->request->wasPosted() ) {
			$action = $this->request->getVal( 'action', null );
			if (
				$action === wfMessage('userlogin-forgot-password')->escaped() ||
				$action === wfMessage('wikiamobile-sendpassword-label')->escaped() ||
				$type === 'forgotPassword'
			) {	// send temporary password
				$response = $this->app->sendRequest( 'UserLoginSpecial', 'mailPassword' );

				$this->result = $response->getVal( 'result', '' );
				$this->msg = $response->getVal( 'msg', '' );
			} else if ($action === wfMessage('resetpass_submit')->escaped() ) {	// change password
				$this->editToken = $this->wg->request->getVal( 'editToken', '' );
				$this->loginToken = $this->wg->Request->getVal( 'loginToken', '' );
				$params = array(
					'username' => $this->username,
					'password' => $this->password,
					'newpassword' => $this->wg->request->getVal( 'newpassword' ),
					'retype' => $this->wg->request->getVal( 'retype' ),
					'editToken' => $this->editToken,
					'loginToken' => $this->loginToken,
					'cancel' => $this->wg->request->getVal( 'cancel', false ),
					'returnto' => $this->returnto
				);
				$response = $this->app->sendRequest( 'UserLoginSpecial', 'changePassword', $params );

				$this->result = $response->getVal( 'result', '' );
				$this->msg = $response->getVal( 'msg', null );

				$this->response->getView()->setTemplate( 'UserLoginSpecial', 'changePassword' );

			} else {	// login
				$response = $this->app->sendRequest( 'UserLoginSpecial', 'login' );

				$this->result = $response->getVal( 'result', '' );
				$this->msg = $response->getVal( 'msg', '' );
				$this->errParam = $response->getVal( 'errParam', '' );

				// set the language object
				$code = $this->wg->request->getVal( 'uselang', $this->wg->User->getOption( 'language' ) );
				$this->wg->Lang = Language::factory( $code );

				if ( $this->result == 'ok' ) {
					// redirect page
					$this->userLoginHelper->doRedirect();
				} elseif ( $this->result == 'unconfirm' ) {
					$response = $this->app->sendRequest('UserLoginSpecial', 'getUnconfirmedUserRedirectUrl', array('username' => $this->username, 'uselang' => $code));
					$redirectUrl = $response->getVal('redirectUrl');
					$this->wg->out->redirect( $redirectUrl );
				} elseif ( $this->result === 'closurerequested' ) {
					$response = $this->app->sendRequest( 'UserLoginSpecial', 'getCloseAccountRedirectUrl' );
					$redirectUrl = $response->getVal( 'redirectUrl' );
					$this->wg->Out->redirect( $redirectUrl );
				} elseif ( $this->result == 'resetpass') {
					$this->editToken = $this->wg->User->getEditToken();
					$this->subheading = wfMessage('resetpass_announce')->escaped();
					$this->wg->Out->setPageTitle( wfMessage('userlogin-password-page-title')->plain() );
					$this->response->getView()->setTemplate( 'UserLoginSpecial', 'changePassword' );
				}
			}
		}

		if ($type === 'forgotPassword') {
			$this->overrideTemplate('forgotPassword');
			// set page title
			$this->wg->Out->setPageTitle( wfMessage('userlogin-forgot-password')->plain() );
			return;
		}

		// we're sure at this point we'll need the private fields'
		// values in the template let's pass them then
		$this->response->setVal( 'username', $this->username );
		$this->response->setVal( 'password', $this->password );

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$recoverParam = 'recover=1';
			$recover = ( $this->wg->request->getInt( 'recover' ) === 1 );

			$this->response->setVal( 'recoverLink', SpecialPage::getTitleFor( 'UserLogin' )->getLocalURL( $recoverParam ) );
			$this->response->setVal( 'recoverPassword', $recover );

			if ( $recover ) {
				//we use different AssetsManager packages for recover and login, so make sure the page URL is different to avoid Varnish clashes
				$this->formPostAction .= "?{$recoverParam}";
			}

			if ( !empty( $action ) && ( $action === wfMessage( 'resetpass_submit' )->escaped()  || $this->result == 'resetpass' ) ) {
				$this->overrideTemplate( 'WikiaMobileChangePassword' );
			} else {
				$this->overrideTemplate( 'WikiaMobileIndex' );
			}
		}
	}

	public function getUnconfirmedUserRedirectUrl() {
		$title = Title::newFromText('UserSignup', NS_SPECIAL);
		$params = array(
			'method' => 'sendConfirmationEmail',
			'username' => $this->getVal('username'),
			'uselang' => $this->getVal('uselang'),
		);
		$this->redirectUrl = $title->getFullUrl( $params );
	}

	public function getCloseAccountRedirectUrl() {
		$this->redirectUrl = SpecialPage::getTitleFor( 'CloseMyAccount', 'reactivate' )->getFullUrl();
	}

	/**
	 * @brief renders html version that will be inserted into ajax based login interaction
	 * @details
	 *   on GET, template partial for an ajax element will render
	 */
	public function dropdown() {
		$query = $this->app->wg->Request->getValues();

		if ( isset( $query['password'] ) ) {
			// remove the password from the params to prevent exposiong in into the URL
			unset($query['password']);
		}

		$this->returnto = $this->getReturnToFromQuery( $query );
		$this->returntoquery = $this->getReturnToQueryFromQuery( $query );

		$requestParams = $this->getRequest()->getParams();
		if ( !empty( $requestParams[ 'registerLink' ] ) ) {
			$this->registerLink = $requestParams[ 'registerLink' ];
		}
		if ( !empty( $requestParams[ 'template' ] ) ) {
			$this->overrideTemplate( $requestParams[ 'template' ] );
		}
	}

	public function getMainPagePartialUrl() {
		return Title::newMainPage()->getPartialURL();
	}

	/**
	 * @param String $title
	 *
	 * @return Boolean
	 */
	public function isTitleBlacklisted( $title ) {
		return AccountNavigationController::isBlacklisted( $title );
	}

	private function getReturnToFromQuery( $query ) {
		if( !is_array( $query ) ) {
			return '';
		}

		$returnto = $this->getMainPagePartialUrl();
		if( isset( $query['title'] ) && !$this->isTitleBlacklisted( $query['title'] ) ) {
			$returnto = $query['title'] ;
			unset( $query['title'] );
		}

		return $returnto;
	}

	private function getReturnToQueryFromQuery( $query ) {
		if( !is_array( $query ) ) {
			return '';
		}

		// CONN-49 an edge-case when while being on Special:UserLogin you fail in logging-in
		// and because of that the returntoquery gets longer and longer with each failure
		if( !empty( $query['returntoquery'] ) ) {
			$prevReturnToQuery = wfCgiToArray( $query['returntoquery'] );
			$query['returntoquery'] = [];
		} else {
			$prevReturnToQuery = [];
		}

		return wfArrayToCGI( $query, $prevReturnToQuery );
	}

	public function providers() {
		$this->response->setVal( 'requestType',  $this->request->getVal( 'requestType', '' ) );

		// don't render FBconnect button when the extension is disabled
		if ( empty( $this->wg->EnableFacebookConnectExt ) ) {
			$this->skipRendering();
		}

		$this->tabindex = $this->request->getVal('tabindex', null);

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileProviders' );
		}
	}

	public function providersTop() {
		$this->response->setVal( 'requestType',  $this->request->getVal( 'requestType', '' ) );

		// don't render FBconnect button when the extension is disabled
		if ( empty( $this->wg->EnableFacebookConnectExt ) ) {
			$this->skipRendering();
		}

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$this->overrideTemplate( 'WikiaMobileProviders' );
		}
	}

	public function modal() {
		$this->loginToken = UserLoginHelper::getLoginToken();
		$this->signupUrl = Title::newFromText('UserSignup', NS_SPECIAL)->getFullUrl();
	}

	/**
	 * @brief retrieves valid login token
	 */
	public function retrieveLoginToken() {
		$this->loginToken = UserLoginHelper::getLoginToken();
	}

	/**
	 * @brief logs in a user with given login name and password.  if keeploggedin, sets a cookie.
	 * @details
	 * @requestParam string username
	 * @requestParam string password
	 * @requestParam string keeploggedin [true/false]
	 * @responseParam string result [ok/error/unconfirm/resetpass]
	 * @responseParam string msg - result message
	 * @responseParam string errParam - error param
	 */
	public function login() {
		// Init session if necessary
		if ( session_id() == '' ) {
			wfSetupSession();
		}

		$loginForm = new LoginForm($this->wg->request);
		$loginForm->load(); // MW1.19 uses different form fields names

		// set variables
		if ( $this->wg->request->getText( 'username', '' ) != '' ) {
			$loginForm->mUsername = $this->wg->request->getText( 'username' );
		}
		if ( $this->wg->request->getText( 'password', '' ) != '' ) {
			$loginForm->mPassword = $this->wg->request->getText( 'password' );
		}
		if ( $this->wg->request->getText( 'keeploggedin', '' ) != '' ) {
			$loginForm->mRemember = $this->wg->request->getCheck( 'keeploggedin' );
		}
		if ( $this->wg->request->getVal( 'loginToken', '' ) != '' ) {
			$loginForm->mToken = $this->wg->request->getVal( 'loginToken' );
		}
		if ( $this->wg->request->getVal( 'returnto', '' ) != '' ) {
			$loginForm->mReturnTo = $this->wg->request->getVal( 'returnto' );
		}

		$loginCase = $loginForm->authenticateUserData();

		/** PLATFORM-508 - logging for Helios project - begin */
		\Wikia\Logger\WikiaLogger::instance()->debug(
			'PLATFORM-508',
			[ 'method' => __METHOD__, 'login_case' => (string) $loginCase ]
		);
		/** PLATFORM-508 - logging for Helios project - end */

		switch ( $loginCase ) {
			case LoginForm::SUCCESS:
				// first check if user has confirmed email after sign up
				if (  $this->wg->User->getOption( self::NOT_CONFIRMED_SIGNUP_OPTION_NAME ) == true ) {
					//User not confirmed on signup
					LoginForm::clearLoginToken();
					$this->userLoginHelper->setNotConfirmedUserSession( $this->wg->User->getId() );
					$this->userLoginHelper->clearPasswordThrottle( $loginForm->mUsername );
					$this->result = 'unconfirm';
					$this->msg = wfMessage( 'usersignup-confirmation-email-sent', $this->wg->User->getEmail() )->parse();
				} else {
					$result = '';
					$resultMsg = '';
					if ( !wfRunHooks( 'WikiaUserLoginSuccess', array( $this->wg->User, &$result, &$resultMsg ) ) ) {
						$this->result = $result;
						$this->msg = $resultMsg;
						break;
					}

					//Login succesful
					$injected_html = '';
					wfRunHooks('UserLoginComplete', array(&$this->wg->User, &$injected_html));

					// set rememberpassword option
					if ( (bool)$loginForm->mRemember != (bool)$this->wg->User->getOption('rememberpassword') ) {
						$this->wg->User->setOption( 'rememberpassword', $loginForm->mRemember ? 1 : 0 );
						$this->wg->User->saveSettings();
					} else {
						$this->wg->User->invalidateCache();
					}
					$this->wg->User->setCookies();
					LoginForm::clearLoginToken();
					UserLoginHelper::clearNotConfirmedUserSession();
					$this->userLoginHelper->clearPasswordThrottle( $loginForm->mUsername );
					// we're sure at this point we'll need the private field'
					// value in the template let's pass them then
					$this->response->setVal( 'username', $loginForm->mUsername );
					$this->result = 'ok';
				}
				break;

			case LoginForm::NEED_TOKEN:
			case LoginForm::WRONG_TOKEN:
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-sessionfailure')->escaped();
				break;
			case LoginForm::NO_NAME:
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-noname')->escaped();
				$this->errParam = 'username';
				break;
			case LoginForm::ILLEGAL:
				$this->result = 'error';
				$this->msg = wfMessage( 'userlogin-error-nosuchuser' )->escaped();
				$this->errParam = 'username';
				break;
			case LoginForm::NOT_EXISTS:
				$this->result = 'error';
				$this->msg = wfMessage( 'userlogin-error-nosuchuser' )->escaped();
				$this->errParam = 'username';
				break;
			case LoginForm::WRONG_PLUGIN_PASS:
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-wrongpassword')->escaped();
				$this->errParam = 'password';
				break;
			case LoginForm::WRONG_PASS:
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-wrongpassword')->escaped();
				$this->errParam = 'password';
				$attemptedUser = User::newFromName($loginForm->mUsername);
				if ( !is_null( $attemptedUser ) ) {
					$disOpt = $attemptedUser->getOption('disabled');
					if( !empty($disOpt) ||
						(defined( 'CLOSED_ACCOUNT_FLAG' ) && $attemptedUser->getRealName() == CLOSED_ACCOUNT_FLAG ) ){
						#either closed account flag was present, override fail message
						$this->msg = wfMessage('userlogin-error-edit-account-closed-flag')->escaped();
						$this->errParam = '';
					}
				}
				break;
			case LoginForm::EMPTY_PASS:
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-wrongpasswordempty')->escaped();
				$this->errParam = 'password';
				break;
			case LoginForm::RESET_PASS:
				$this->result = 'resetpass';
				break;
			case LoginForm::THROTTLED:
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-login-throttled')->escaped();
				break;
			case LoginForm::CREATE_BLOCKED:
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-cantcreateaccount-text')->escaped();
				break;
			case LoginForm::USER_BLOCKED:
				$this->result = 'error';
				$this->msg = wfMessage( 'userlogin-error-login-userblocked' )->escaped();
				break;
			default:
				throw new MWException( "Unhandled case value" );
		}

	}

	/**
	 * @brief sends an email to username's address
	 * @details
	 *   if success, send email
	 *   if no email addy for username, set error and msg
	 *   if no username, set error and msg
	 * @requestParam string username
	 * @responseParam string result [ok/noemail/error/null]
	 * @responseParam string msg - result message
	 */
	public function mailPassword() {
		$loginForm = new LoginForm($this->wg->request);
		if ( $this->wg->request->getText( 'username', '' ) != '' ) {
			$loginForm->mUsername = $this->wg->request->getText( 'username' );
		}

		if ( $loginForm->mUsername == '' ) {
			$this->result = 'error';
			$this->msg = wfMessage('userlogin-error-noname')->escaped();
		} else if ( !$this->wg->Auth->allowPasswordChange() ) {
			$this->result = 'error';
			$this->msg = wfMessage('userlogin-error-resetpass_forbidden')->escaped();
		} else if ( $this->wg->User->isBlocked() ) {
			$this->result = 'error';
			$this->msg = wfMessage('userlogin-error-blocked-mailpassword')->escaped();
		} else {
			$user = User::newFromName( $loginForm->mUsername );
			if ( !$user instanceof User ) {
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-noname')->escaped();
			} else if ( $user->getID() == 0 ) {
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-nosuchuser')->escaped();
			} else if ( $user->isPasswordReminderThrottled() ) {
				$this->result = 'error';
				$this->msg = wfMessage('userlogin-error-throttled-mailpassword', round( $this->wg->PasswordReminderResendTime, 3) )->escaped();
			} else {
				$emailTextTemplate = $this->app->renderView( "UserLogin", "GeneralMail", array('language' => $user->getOption('language'), 'type' => 'password-email') );
				$result = $loginForm->mailPasswordInternal( $user, true, 'userlogin-password-email-subject', 'userlogin-password-email-body', $emailTextTemplate );
				if( !$result->isGood() ) {
					$this->result = 'error';
					$this->msg = wfMessage('userlogin-error-mail-error', $result->getMessage() )->parse();
				} else {
					$this->result = 'ok';
					$this->msg = wfMessage('userlogin-password-email-sent', $loginForm->mUsername )->escaped();
				}
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
		$this->wg->Out->setPageTitle(wfMessage('userlogin-password-page-title')->plain());
		$this->pageHeading = wfMessage('resetpass')->escaped();
		$this->initializeTemplate();

		$this->username = $this->request->getVal( 'username', '' );
		$this->password = $this->request->getVal( 'password', '' );
		$this->newpassword = $this->request->getVal( 'newpassword', '' );
		$this->retype = $this->request->getVal( 'retype', '' );
		$this->editToken = $this->request->getVal( 'editToken', '' );
		$this->loginToken = $this->request->getVal( 'loginToken', '' );
		$this->returnto = $this->request->getVal( 'returnto', '' );

		// since we don't support ajax GET, use of this parameter simulates a get request
		// in reality, it is being posted
		$fakeGet = $this->request->getVal('fakeGet', '');
		$this->editToken = $this->wg->User->getEditToken();

		if ( $this->wg->request->wasPosted() && empty($fakeGet) ) {
			if( !$this->wg->Auth->allowPasswordChange() ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'resetpass_forbidden' )->escaped();
				return;
			}

			if( $this->request->getVal( 'cancel', false ) ) {
				$this->userLoginHelper->doRedirect();
				return;
			}

			if( $this->wg->User->matchEditToken( $this->editToken ) ) {

				if ( $this->wg->User->isAnon()
					&& $this->loginToken !== UserLoginHelper::getLoginToken()
				) {
					$this->result = 'error';
					$this->msg = wfMessage( 'sessionfailure' )->escaped();
					return;
				}

				$user =  User::newFromName( $this->username );

				if( !$user || $user->isAnon() ) {
					$this->result = 'error';
					$this->msg = wfMessage( 'userlogin-error-nosuchuser' )->escaped();
					return;
				}

				if( $this->newpassword !== $this->retype ) {
					$this->result = 'error';
					$this->msg = wfMessage( 'badretype' )->escaped();
					wfRunHooks( 'PrefsPasswordAudit', array( $user, $this->newpassword, 'badretype' ) );
					return;
				}

				// from attemptReset() in SpecialResetpass
				if( !$user->checkTemporaryPassword($this->password) && !$user->checkPassword($this->password) ) {
					$this->result = 'error';
					$this->msg = wfMessage( 'userlogin-error-wrongpassword' )->escaped();
					wfRunHooks( 'PrefsPasswordAudit', array( $user, $this->newpassword, 'wrongpassword' ) );
					return;
				}

				$valid = $user->getPasswordValidity( $this->newpassword );
				if ( $valid !== true ) {
					$this->result = 'error';
					$this->msg = wfMessage( $valid, $this->wg->MinimalPasswordLength )->text();
					return;
				}

				$user->setPassword( $this->newpassword );
				wfRunHooks( 'PrefsPasswordAudit', array( $user, $this->newpassword, 'success' ) );
				$user->saveSettings();

				$this->result = 'ok';
				$this->msg = wfMessage( 'resetpass_success' )->escaped();

				$this->wg->request->setVal( 'password', $this->newpassword );
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
