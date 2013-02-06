<?php

/**
 * UserLogin Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class UserLoginSpecialController extends WikiaSpecialPageController {
	const DROPDOWN_TABINDEX_START =  2;
	const SPECIAL_USERLOGIN_TABINDEX_START = 7;

	private $userLoginHelper = null;

	public function __construct() {
		parent::__construct( 'UserLogin', '', false );
	}

	public function init() {
		$loginTitle = SpecialPage::getTitleFor( 'UserLogin' );
		$this->formPostAction = $loginTitle->getLocalUrl();
		$this->isMonobookOrUncyclo = ( $this->wg->User->getSkin() instanceof SkinMonoBook || $this->wg->User->getSkin() instanceof SkinUncyclopedia );
		$this->userLoginHelper = F::build( 'UserLoginHelper' );
	}

	private function initializeTemplate() {
		//Oasis/Monobook, will be filtered in AssetsManager :)
		$this->response->addAsset( 'extensions/wikia/UserLogin/css/UserLogin.scss' );
		if ( !empty($this->wg->EnableFacebookConnectExt) ) {
			$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginFacebookPageInit.js' );
		}

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
		//new, probably temp asset as a fix for P2, bugId:96140
		$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginSpecial.js' );
		
		// redirect if signup
		$type = $this->request->getVal('type', '');
		if($type === 'signup') {
			$title = SpecialPage::getTitleFor( 'UserSignup' );
			$this->wg->Out->redirect( $title->getFullURL() );
			return false;
		}

		$this->initializeTemplate();

		// set page title
		$this->wg->Out->setPageTitle(wfMsg('userlogin-login-heading'));

		// params
		$this->username = $this->request->getVal( 'username', '' );
		$this->password = $this->request->getVal( 'password', '' );
		$this->keeploggedin = $this->request->getCheck( 'keeploggedin' );
		$this->loginToken = UserLoginHelper::getLoginToken();
		$this->returnto = htmlentities($this->request->getVal( 'returnto', '' ), ENT_QUOTES, "UTF-8");
		$this->returntoquery = htmlentities($this->request->getVal( 'returntoquery', '' ), ENT_QUOTES, "UTF-8");

		// process login
		if ( $this->wg->request->wasPosted() ) {
			$action = $this->request->getVal( 'action', null );
			if (
				$action === $this->wf->Msg('userlogin-forgot-password') ||
				$action === $this->wf->Msg('wikiamobile-sendpassword-label')
			) {	// send temporary password
				$response = $this->app->sendRequest( 'UserLoginSpecial', 'mailPassword' );

				$this->result = $response->getVal( 'result', '' );
				$this->msg = $response->getVal( 'msg', '' );
			} else if ($action === $this->wf->Msg('resetpass_submit') ) {	// change password
				$this->editToken = $this->wg->request->getVal( 'editToken', '' );
				$params = array(
					'username' => $this->username,
					'password' => $this->password,
					'newpassword' => $this->wg->request->getVal( 'newpassword' ),
					'retype' => $this->wg->request->getVal( 'retype' ),
					'editToken' => $this->editToken,
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
				} else if ( $this->result == 'unconfirm' ) {
					$response = $this->app->sendRequest('UserLoginSpecial', 'getUnconfirmedUserRedirectUrl', array('username' => $this->username, 'uselang' => $code));
					$redirectUrl = $response->getVal('redirectUrl');
					$this->wg->out->redirect( $redirectUrl );
				} else if ( $this->result == 'resetpass') {
					$this->editToken = $this->wg->User->getEditToken();
					$this->subheading = wfMsg('resetpass_announce');
					$this->wg->Out->setPageTitle($this->wf->Msg('userlogin-password-page-title'));
					$this->response->getView()->setTemplate( 'UserLoginSpecial', 'changePassword' );
				}
			}
		}

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			$recoverParam = 'recover=1';
			$recover = ( $this->wg->request->getInt( 'recover' ) === 1 );

			$this->response->setVal( 'recoverLink', SpecialPage::getTitleFor( 'UserLogin' )->getLocalURL( $recoverParam ) );
			$this->response->setVal( 'recoverPassword', $recover );

			if ( $recover ) {
				//we use different AssetsManager packages for recover and login, so make sure the page URL is different to avoid Varnish clashes
				$this->formPostAction .= "?{$recoverParam}";
			}

			if ( !empty( $action ) && ( $action === $this->wf->Msg( 'resetpass_submit' )  || $this->result == 'resetpass' ) ) {
				$this->overrideTemplate( 'WikiaMobileChangePassword' );
			} else {
				$this->overrideTemplate( 'WikiaMobileIndex' );
			}
		}
		
		$this->tabindex = self::SPECIAL_USERLOGIN_TABINDEX_START;
		$this->formData = $this->generateFormData();
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

	/**
	 * @brief renders html version that will be inserted into ajax based login interaction
	 * @details
	 *   on GET, template partial for an ajax element will render
	 */
	public function dropdown() {
		$query = $this->app->wg->Request->getValues();
		if( isset($query['title']) ) {
			$this->returnto = $query['title'];
			unset($query['title']);
		}
		
		$this->tabindex = self::DROPDOWN_TABINDEX_START;
		$this->suppressCreateAccount = true;
		$this->supressLogInBtnBig = true;
		$this->returntoquery = $this->app->wf->ArrayToCGI( $query );

		$this->formData = $this->generateFormData();
	}

	public function modal() {
		$this->loginToken = UserLoginHelper::getLoginToken();
		$this->signupUrl = Title::newFromText('UserSignup', NS_SPECIAL)->getFullUrl();

		$this->tabindex = self::SPECIAL_USERLOGIN_TABINDEX_START;
		$this->formData = $this->generateFormData();
	}

	public function providers() {
		$this->response->setVal( 'requestType',  $this->request->getVal( 'requestType', '' ) );
		$this->response->setVal( 'tabindex',  $this->request->getVal( 'tabindex', null ) );

		// don't render FBconnect button when the extension is disabled
		if ( empty( $this->wg->EnableFacebookConnectExt ) ) {
			$this->skipRendering();
		}

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
			$this->wf->SetupSession();
		}

		$loginForm = F::build( 'LoginForm', array(&$this->wg->request) );
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

		switch ( $loginCase ) {
			case LoginForm::SUCCESS:
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
					TempUser::clearTempUserSession();
					$this->userLoginHelper->clearPasswordThrottle( $loginForm->mUsername );

					$this->result = 'ok';
				break;

			case LoginForm::NEED_TOKEN:
			case LoginForm::WRONG_TOKEN:
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-sessionfailure');
				break;
			case LoginForm::NO_NAME:
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-noname');
				$this->errParam = 'username';
				break;
			case LoginForm::ILLEGAL:
				$this->result = 'error';
				$this->msg = $this->wf->Msg( 'userlogin-error-nosuchuser' );
				$this->errParam = 'username';
				break;
			case LoginForm::NOT_EXISTS:
				$tempUser = F::build( 'TempUser', array($loginForm->mUsername), 'getTempUserFromName' );
				if ( $tempUser ) {
					if ( $this->userLoginHelper->isPasswordThrottled($loginForm->mUsername) ) {
						$this->result = 'error';
						$this->msg = $this->wf->Msg( 'userlogin-error-login-throttled' );
					} else {
						$user = $tempUser->mapTempUserToUser( false );
						if ( $user->checkPassword($loginForm->mPassword) ) {
							LoginForm::clearLoginToken();
							$tempUser->setTempUserSession();
							$this->userLoginHelper->clearPasswordThrottle( $loginForm->mUsername );

							// set lang for unconfirmed user
							$langCode = $user->getOption('language');
							if ( $this->wg->User->getOption('language') != $langCode ) {
								$this->wg->User->setOption( 'language', $langCode );
							}

							$this->result = 'unconfirm';
							$this->msg = $this->wf->MsgExt( 'usersignup-confirmation-email-sent', array('parseinline'), $tempUser->getEmail() );
						} else if ( $user->checkTemporaryPassword($loginForm->mPassword) ) {
							$this->result = 'resetpass';
						} else {
							$this->result = 'error';
							$this->msg = $this->wf->Msg( 'userlogin-error-wrongpassword' );
							$this->errParam = 'password';
						}
					}
				} else {
					$this->result = 'error';
					$this->msg = $this->wf->Msg( 'userlogin-error-nosuchuser' );
					$this->errParam = 'username';
				}
				break;
			case LoginForm::WRONG_PLUGIN_PASS:
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-wrongpassword');
				$this->errParam = 'password';
				break;
			case LoginForm::WRONG_PASS:
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-wrongpassword');
				$this->errParam = 'password';
				$attemptedUser = F::build( 'User', array($loginForm->mUsername), 'newFromName' );
				if ( !is_null( $attemptedUser ) ) {
					$disOpt = $attemptedUser->getOption('disabled');
					if( !empty($disOpt) ||
						(defined( 'CLOSED_ACCOUNT_FLAG' ) && $attemptedUser->getRealName() == CLOSED_ACCOUNT_FLAG ) ){
						#either closed account flag was present, override fail message
						$this->msg = $this->wf->Msg('userlogin-error-edit-account-closed-flag');
						$this->errParam = '';
					}
				}
				break;
			case LoginForm::EMPTY_PASS:
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-wrongpasswordempty');
				$this->errParam = 'password';
				break;
			case LoginForm::RESET_PASS:
				$this->result = 'resetpass';
				break;
			case LoginForm::THROTTLED:
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-login-throttled');
				break;
			case LoginForm::CREATE_BLOCKED:
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-cantcreateaccount-text');
				break;
			case LoginForm::USER_BLOCKED:
				$this->result = 'error';
				$this->msg = $this->wf->Msg( 'userlogin-error-login-userblocked' );
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
		$loginForm = F::build( 'LoginForm', array(&$this->wg->request) ); /** @var LoginForm $loginForm */
		if ( $this->wg->request->getText( 'username', '' ) != '' ) {
			$loginForm->mUsername = $this->wg->request->getText( 'username' );
		}

		if ( $loginForm->mUsername == '' ) {
			$this->result = 'error';
			$this->msg = $this->wf->Msg('userlogin-error-noname');
		} else if ( !$this->wg->Auth->allowPasswordChange() ) {
			$this->result = 'error';
			$this->msg = $this->wf->Msg('userlogin-error-resetpass_forbidden');
		} else if ( $this->wg->User->isBlocked() ) {
			$this->result = 'error';
			$this->msg = $this->wf->Msg('userlogin-error-blocked-mailpassword');
		} else {
			$tempUser = F::build( 'TempUser', array($loginForm->mUsername), 'getTempUserFromName' );
			if ( $tempUser ) {
				$user = $tempUser->mapTempUserToUser( false );
			} else {
				$user = F::build( 'User', array($loginForm->mUsername), 'newFromName' );
			}

			if ( !$user instanceof User ) {
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-noname');
			} else if ( $user->getID() == 0 ) {
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-nosuchuser');
			} else if ( $user->isPasswordReminderThrottled() ) {
				$this->result = 'error';
				$this->msg = $this->wf->Msg('userlogin-error-throttled-mailpassword', round( $this->wg->PasswordReminderResendTime, 3) );
			} else {
				$emailTextTemplate = $this->app->renderView( "UserLogin", "GeneralMail", array('language' => $user->getOption('language'), 'type' => 'password-email') );
				$result = $loginForm->mailPasswordInternal( $user, true, 'userlogin-password-email-subject', 'userlogin-password-email-body', $emailTextTemplate );
				if( !$result->isGood() ) {
					$this->result = 'error';
					$this->msg = $this->wf->Message('userlogin-error-mail-error', $result->getMessage() )->parse();
				} else {
					$this->result = 'ok';
					$this->msg = $this->wf->Msg('userlogin-password-email-sent', $loginForm->mUsername );
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
		$this->wg->Out->setPageTitle($this->wf->Msg('userlogin-password-page-title'));
		$this->pageHeading = $this->wf->Msg('resetpass');
		$this->initializeTemplate();

		$this->username = $this->request->getVal( 'username', '' );
		$this->password = $this->request->getVal( 'password', '' );
		$this->newpassword = $this->request->getVal( 'newpassword', '' );
		$this->retype = $this->request->getVal( 'retype', '' );
		$this->editToken = $this->request->getVal( 'editToken', '' );
		$this->returnto = $this->request->getVal( 'returnto', '' );

		// since we don't support ajax GET, use of this parameter simulates a get request
		// in reality, it is being posted
		$fakeGet = $this->request->getVal('fakeGet', '');
		$this->editToken = $this->wg->User->getEditToken();

		if ( $this->wg->request->wasPosted() && empty($fakeGet) ) {
			if( !$this->wg->Auth->allowPasswordChange() ) {
				$this->result = 'error';
				$this->msg = $this->wf->Msg( 'resetpass_forbidden' );
				return;
			}

			if( $this->request->getVal( 'cancel', false ) ) {
				$this->userLoginHelper->doRedirect();
				return;
			}

			if( $this->wg->User->matchEditToken( $this->editToken ) ) {
				$tempUser = F::build( 'TempUser', array( $this->username ), 'getTempUserFromName' );
				if ( $tempUser ) {
					$user = $tempUser->mapTempUserToUser( false );
					$tempUser->activateUser($user);
				} else {
					$user =  F::build( 'User', array( $this->username ), 'newFromName' );
				}

				if( !$user || $user->isAnon() ) {
					$this->result = 'error';
					$this->msg = $this->wf->Msg( 'userlogin-error-nosuchuser' );
					return;
				}

				if( $this->newpassword !== $this->retype ) {
					$this->result = 'error';
					$this->msg = $this->wf->Msg( 'badretype' );
					wfRunHooks( 'PrefsPasswordAudit', array( $user, $this->newpassword, 'badretype' ) );
					return;
				}

				// from attemptReset() in SpecialResetpass
				if( !$user->checkTemporaryPassword($this->password) && !$user->checkPassword($this->password) ) {
					$this->result = 'error';
					$this->msg = $this->wf->Msg( 'userlogin-error-wrongpassword' );
					wfRunHooks( 'PrefsPasswordAudit', array( $user, $this->newpassword, 'wrongpassword' ) );
					return;
				}

				$valid = $user->getPasswordValidity( $this->newpassword );
				if ( $valid !== true ) {
					$this->result = 'error';
					$this->msg = $this->wf->MsgExt( $valid, array( 'parsemag' ), $this->wg->MinimalPasswordLength );
					return;
				}

				$user->setPassword( $this->newpassword );
				wfRunHooks( 'PrefsPasswordAudit', array( $user, $this->newpassword, 'success' ) );
				$user->setCookies();
				$user->saveSettings();

				$this->result = 'ok';
				$this->msg = $this->wf->Msg( 'resetpass_success' );

				$this->wg->request->setVal( 'password', $this->newpassword );
				$response = $this->app->sendRequest( 'UserLoginSpecial', 'login' );

				$this->userLoginHelper->doRedirect();
			}
		}
	}

	/**
	 * @desc Generates form array used in index(), modal() and dropdown() methods
	 * @return array
	 */
	protected function generateFormData() {
		$loginTokenInput = array(
			'type' => 'hidden',
			'name' => 'loginToken',
			'value' => $this->loginToken
		);

		$userNameInput = array(
			'type' => 'text',
			'name' => 'username',
			'isRequired' => true,
			'label' => wfMsg('yourname'),
			'isInvalid' => (!empty($this->errParam) && $this->errParam === 'username'),
			'value' => htmlspecialchars($this->username),
			'tabindex' => ++$this->tabindex,
		);
		$userNameInput['errorMsg'] = $userNameInput['isInvalid'] ? $this->msg : '';

		$passwordInput = array(
			'type' => 'password',
			'class' => 'password-input',
			'name' => 'password',
			'isRequired' => true,
			'label' => wfMsg('yourpassword'),
			'isInvalid' => (!empty($this->errParam) && $this->errParam === 'password'),
			'value' => htmlspecialchars($this->password),
			'tabindex' => ++$this->tabindex,
		);
		$passwordInput['errorMsg'] = $passwordInput['isInvalid'] ? $this->msg : '';

		$forgotPassword = array(
			'type' => 'custom',
			'class' => 'forgot-password',
			'output' => '<a href="#" tabindex="0" class="forgot-your-password-link">' . wfMsg('userlogin-forgot-password') . '</a>',
		);

		$rememberMeInput = array(
			'type' => 'checkbox',
			'name' => 'keeploggedin',
			'isRequired' => false,
			'value' => '1',
			'checked' => $this->keeploggedin,
			'class' => 'keep-logged-in',
			'label' => wfMsg('userlogin-remembermypassword'),
			'tabindex' => ++$this->tabindex,
		);

		$loginButton = array(
			'type' => 'submit',
			'value' => wfMsg('login'),
			'class' => 'login-button',
			'tabindex' => ++$this->tabindex,
		);
		
		if( empty($this->supressLogInBtnBig) ) {
			$loginButton['class'] .= ' big';
		}

		$form = array(
			'inputs' => array(
				$loginTokenInput,
				$userNameInput,
				$passwordInput,
				$forgotPassword,
				$rememberMeInput,
				$loginButton,
			),
			'action' => $this->formPostAction,
			'method' => 'post',
		);
		
		if( empty($this->suppressCreateAccount) ) {
			$specialSignupLink = SpecialPage::getTitleFor('UserSignup')->getLocalURL();
			$createAccount = array(
				'type' => 'custom',
				'output' => wfMsgExt('userlogin-get-account', 'content', array($specialSignupLink, ++$this->tabindex)),
				'class' => 'get-account'
			);
			$form['inputs'][] = $createAccount;
		}

		$form['isInvalid'] = !empty($this->result) && empty($this->errParam) && !empty($this->msg);
		$form['errorMsg'] = !empty($this->msg) ? $this->msg : '';
		
		if( !empty($this->returnto) ) {
			$form['inputs'][] = array(
				'type' => 'hidden',
				'name' => 'returnto',
				'value' => $this->returnto
			);
		}

		if( !empty($this->returntoquery) ) {
			$form['inputs'][] = array(
				'type' => 'hidden',
				'name' => 'returntoquery',
				'value' => $this->returntoquery
			);
		}
		
		return $form;
	}

}
