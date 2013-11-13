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
		
		$this->wg->Out->setPageTitle( wfMessage('wikiaconfirmemail-heading')->plain() );

		$par = $this->request->getVal( 'par', '' );
		$this->code = $this->request->getVal( 'code', $par );
		$this->username = $this->request->getVal( 'username', '' );
		$this->password = $this->request->getVal( 'password', '' );

		if ( $this->code == '' ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'wikiaconfirmemail-error-empty-code' )->escaped();
			return;
		}

		if ( $this->wg->request->wasPosted() ) {
			if ( $this->username == '' ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'userlogin-error-noname' )->escaped();
				$this->errParam = 'username';
				return;
			}

			if ( $this->password == '' ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'userlogin-error-wrongpasswordempty' )->escaped();
				$this->errParam = 'password';
				return;
			}

			$expUser = User::newFromConfirmationCode( $this->code );
			if ( !is_object( $expUser ) ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'wikiaconfirmemail-error-invalid-code' )->escaped();
				return;
			}

			// User - activate user, confirm email and redirect to user page or create new wiki
			$user = User::newFromName( $this->username );
			if ( $user->getId() != $expUser->getId() ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'wikiaconfirmemail-error-user-not-match' )->escaped();
				$this->errParam = 'username';
				return;
			}

			$userLoginHelper = new UserLoginHelper ; /* @var UserLoginHelper $userLoginHelper */
			if ( $userLoginHelper->isPasswordThrottled( $this->username ) ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'userlogin-error-login-throttled' )->escaped();
				$this->errParam = 'password';
				return;
			}

			if ( $user->checkPassword( $this->password ) ) {
				$this->wg->User = $user;
				$this->wg->User->setCookies();
				LoginForm::clearLoginToken();
				UserLoginHelper::clearNotConfirmedUserSession();
				$userLoginHelper->clearPasswordThrottle( $this->username );

				if ( $user->getOption( UserLoginSpecialController::NOT_CONFIRMED_SIGNUP_OPTION_NAME ) != null ){// Signup confirm

					// Confirm
					UserLoginHelper::removeNotConfirmedFlag( $user );
					$user->confirmEmail();

					// Get and clear redirect page
					$userSignupRedirect = $user->getOption( UserLoginSpecialController::SIGNUP_REDIRECT_OPTION_NAME );
					$user->setOption( UserLoginSpecialController::SIGNUP_REDIRECT_OPTION_NAME, null );

					$user->saveSettings();

					// send welcome email
					$emailParams = array(
						'$USERNAME' => $user->getName(),
						'$EDITPROFILEURL' => $user->getUserPage()->getFullURL(),
						'$LEARNBASICURL' => 'http://community.wikia.com/wiki/Help:Wikia_Basics',
						'$EXPLOREWIKISURL' => 'http://www.wikia.com',
                    );

					$userLoginHelper->sendEmail( $user, 'WelcomeMail', 'usersignup-welcome-email-subject', 'usersignup-welcome-email-body', $emailParams, 'welcome-email', 'WelcomeMail' );

					// redirect user
					if ( !empty( $userSignupRedirect ) ) {// Redirect user to the point where he finished (when signup on create wiki)
						$titleObj = SpecialPage::getTitleFor( 'CreateNewWiki' );
						$query = $userSignupRedirect;
					} else {
						$titleObj = $this->wg->User->getUserPage();
						$query = '';
					}
					$this->wg->out->redirect( $titleObj->getFullURL( $query ) );
					return;

				} else {// Email change

					$optionNewEmail = $this->wg->User->getOption( 'new_email' );
					if ( !empty( $optionNewEmail ) ) {
						$user->setEmail( $optionNewEmail );
					}
					$user->confirmEmail();
					$user->setOption( 'new_email', null );
					$user->saveSettings();

					// redirect user
					$userPage = $user->getUserPage();
					$this->wg->out->redirect( $userPage->getFullURL() );
					return;

				}

			} else {
				$this->result = 'error';
				$this->msg = wfMessage( 'userlogin-error-wrongpassword' )->escaped();
				$this->errParam = 'password';
				return;
			}
		}
	}

}
