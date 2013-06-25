<?php

/**
 * WikiaConfirmEmail Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class WikiaConfirmEmailSpecialController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('WikiaConfirmEmail', '', false);
	}

	public function init() {

	}

	/**
	 * Confirm email page.
	 * @requestParam string code - on GET, POST
	 * @requestParam string username - on POST
	 * @requestParam string password - on POST
	 * @responseParam string result [ok/error]
	 * @responseParam string msg - result messages
	 * @responseParam string errParam - error param
	 */
	public function index() {
		$this->response->addAsset('extensions/wikia/UserLogin/css/UserLogin.scss');
	
		// hide things in the skin
		$this->wg->SuppressWikiHeader = false;
		$this->wg->SuppressPageHeader = false;
		$this->wg->SuppressFooter = true;
		$this->wg->SuppressAds = true;
		$this->wg->SuppressToolbar = true;
		
		$this->wg->Out->setPageTitle(wfMsg('wikiaconfirmemail-heading'));

		$par = $this->request->getVal( 'par', '' );
		$this->code = $this->request->getVal( 'code', $par );
		$this->username = $this->request->getVal( 'username', '' );
		$this->password = $this->request->getVal( 'password', '' );

		if ( $this->code == '' ) {
			$this->result = 'error';
			$this->msg = wfMsg( 'wikiaconfirmemail-error-empty-code' );
			return;
		}

		if ( $this->wg->request->wasPosted() ) {
			if ( $this->username == '' ) {
				$this->result = 'error';
				$this->msg = wfMsg( 'userlogin-error-noname' );
				$this->errParam = 'username';
				return;
			}

			if ( $this->password == '' ) {
				$this->result = 'error';
				$this->msg = wfMsg( 'userlogin-error-wrongpasswordempty' );
				$this->errParam = 'password';
				return;
			}

			$expUser = User::newFromConfirmationCode( $this->code );
			if ( !is_object( $expUser ) ) {
				$this->result = 'error';
				$this->msg = wfMsg( 'wikiaconfirmemail-error-invalid-code' );
				return;
			}

			// User - activate user, confirm email and redirect to user page or create new wiki
			$tempUser = TempUser::getTempUserFromName( $this->username );
			if ( $tempUser ) {
				if ( $tempUser->getId() != $expUser->getId() ) {
					$this->result = 'error';
					$this->msg = wfMsg( 'wikiaconfirmemail-error-user-not-match' );
					$this->errParam = 'username';
					return;
				}

				$userLoginHelper = (new UserLoginHelper);
				if ( $userLoginHelper->isPasswordThrottled($this->username) ) {
					$this->result = 'error';
					$this->msg = wfMsg( 'userlogin-error-login-throttled' );
					$this->errParam = 'password';
					return;
				}

				$user = $tempUser->mapTempUserToUser( false );
				if ( $user->checkPassword($this->password) ) {
					$this->wg->user = $tempUser->activateUser( $user );
					$this->wg->User->setCookies();
					LoginForm::clearLoginToken();
					TempUser::clearTempUserSession();
					$userLoginHelper->clearPasswordThrottle( $this->username );

					// redirect user
					if ( $tempUser->getSource() == '' ) {
						$titleObj = $this->wg->User->getUserPage();
						$query = '';
					} else {
						$titleObj = SpecialPage::getTitleFor( 'CreateNewWiki' );
						$query = $tempUser->getSource();
					}
					$this->wg->out->redirect( $titleObj->getFullURL($query) );
					return;
				} else {
					$this->result = 'error';
					$this->msg = wfMsg( 'userlogin-error-wrongpassword' );
					$this->errParam = 'password';
					return;
				}
			}

			// User - confirm email and redirect to user page
			$user = User::newFromName( $this->username );
			if ( ( !( $user instanceof User ) ) || ( $user->getId() != $expUser->getId() ) ) {
				$this->result = 'error';
				$this->msg = wfMsg( 'wikiaconfirmemail-error-user-not-match' );
				$this->errParam = 'username';
				return;
			}

			// set login token
			$this->wg->request->setVal( 'loginToken', UserLoginHelper::getLoginToken() );

			// login
			$response = $this->app->sendRequest( 'UserLoginSpecial', 'login' );

			$this->result = $response->getVal( 'result', '' );
			$this->msg = $response->getVal( 'msg', '' );
			$this->errParam = $response->getVal( 'errParam', '' );

			if ( $this->result == 'ok' ) {
				$optionNewEmail = $this->wg->User->getOption( 'new_email' );
				if ( !empty($optionNewEmail) ) {
					$user->setEmail( $optionNewEmail );
				}
				$user->confirmEmail();
				$user->setOption( 'new_email', null );
				$user->saveSettings();

				wfRunHooks( 'ConfirmEmailComplete', array( &$user ) );

				// redirect user
				$userPage = $user->getUserPage();
				$this->wg->out->redirect( $userPage->getFullURL() );
			}
		}
	}

}