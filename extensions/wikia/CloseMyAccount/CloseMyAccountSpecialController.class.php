<?php

/**
 * CloseMyAccount special page
 *
 * @author Daniel Grunwell (grunny)
 */
class CloseMyAccountSpecialController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'CloseMyAccount' );
	}

	/**
	 * Main special page entry point
	 *
	 * Handles requesting account closure.
	 *
	 * @return void
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$user = $this->getUser();

		$this->specialPage->setHeaders();

		if ( $this->getPar() === 'reactivate' ) {
			$this->forward( 'CloseMyAccountSpecial', 'reactivate' );
			wfProfileOut( __METHOD__ );
			return;
		}

		if ( !$user->isLoggedIn() ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return;
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$helper = new CloseMyAccountHelper();

		$this->response->addModuleStyles( 'ext.closeMyAccount' );

		$waitPeriod = $this->getLanguage()->formatNum( CloseMyAccountHelper::CLOSE_MY_ACCOUNT_WAIT_PERIOD );

		$this->editToken = $user->getEditToken();
		$this->showForm = true;

		if ( $this->request->wasPosted() && $user->matchEditToken( $this->getVal( 'token' ) ) ) {

			$scheduleCloseAccount = $helper->scheduleCloseAccount( $user );

			if ( $scheduleCloseAccount ) {
				$user->logout();
				$this->introText = $this->msg( 'closemyaccount-scheduled', $this->getLanguage()->formatNum( CloseMyAccountHelper::CLOSE_MY_ACCOUNT_WAIT_PERIOD ) )->parseAsBlock();
				$this->showForm = false;
			} else {
				$this->introText = '';
				$this->warning = $this->msg( 'closemyaccount-scheduled-failed' )->parse();
				$this->showForm = false;
			}

		} else {

			$this->introText = $this->msg( 'closemyaccount-intro-text', $waitPeriod )->parseAsBlock();

			if ( !$user->isEmailConfirmed() ) {
				$this->warning = $this->msg( 'closemyaccount-unconfirmed-email' )->parse();
			}

			$buttonParams = [
				'type' => 'button',
				'vars' => [
					'type' => 'submit',
					'classes' => [ 'wikia-button',  'big', 'closemyaccount' ],
					'value' => $this->msg( 'closemyaccount-button-text' )->text(),
					'data' => [],
				]
			];

			$this->submitButton = \Wikia\UI\Factory::getInstance()->init( 'button' )->render( $buttonParams );

		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Entry point for reactivating an account
	 *
	 * Handles confirming the user's reactivation request when they have
	 * given a valid confirmation code. If no code is given, but they have
	 * a session ID from having successfully attempted to login to an account
	 * that has requested closure, this forwards to the reactivateRequest
	 * method.
	 *
	 * @return void
	 */
	public function reactivate() {
		wfProfileIn( __METHOD__ );

		$this->code = $this->getVal( 'code', false );

		if ( empty( $this->code ) ) {
			if ( $this->request->getSessionData( 'closeAccountSessionId' ) !== null ) {
				$this->forward( __CLASS__, 'reactivateRequest' );
			} else {
				$this->success = false;
				$this->resultMessage = $this->msg( 'wikiaconfirmemail-error-empty-code' )->escaped();
			}
			wfProfileOut( __METHOD__ );
			return;
		}

		$this->getOutput()->setPageTitle( $this->msg( 'closemyaccount-reactivate-page-title' )->plain() );
		$this->response->addAsset( 'extensions/wikia/UserLogin/css/UserLogin.scss' );

		$this->username = $this->request->getVal( 'username', '' );
		$this->password = $this->request->getVal( 'password', '' );

		$helper = new CloseMyAccountHelper();

		if ( $this->request->wasPosted() ) {
			if ( $this->username === '' ) {
				$this->success = false;
				$this->resultMessage = $this->msg( 'userlogin-error-noname' )->escaped();
				$this->errParam = 'username';
				wfProfileOut( __METHOD__ );
				return;
			}

			if ( $this->password === '' ) {
				$this->success = false;
				$this->resultMessage = $this->msg( 'userlogin-error-wrongpasswordempty' )->escaped();
				$this->errParam = 'password';
				wfProfileOut( __METHOD__ );
				return;
			}

			$expUser = User::newFromConfirmationCode( $this->code );
			if ( !( $expUser instanceof User ) ) {
				$this->success = false;
				$this->resultMessage = $this->msg( 'wikiaconfirmemail-error-invalid-code' )->escaped();
				wfProfileOut( __METHOD__ );
				return;
			}

			$user = User::newFromName( $this->username );
			if ( $user->getId() != $expUser->getId() ) {
				$this->success = false;
				$this->resultMessage = $this->msg( 'wikiaconfirmemail-error-user-not-match' )->escaped();
				$this->errParam = 'username';
				wfProfileOut( __METHOD__ );
				return;
			}

			$userLoginHelper = new UserLoginHelper(); /* @var UserLoginHelper $userLoginHelper */
			if ( $userLoginHelper->isPasswordThrottled( $this->username ) ) {
				$this->success = false;
				$this->resultMessage = $this-msg( 'userlogin-error-login-throttled' )->escaped();
				$this->errParam = 'password';
				wfProfileOut( __METHOD__ );
				return;
			}

			if ( $helper->isClosed( $user ) ) {
				$this->success = false;
				$this->resultMessage = $this->msg( 'closemyaccount-reactivate-error-disabled' )->parse();
				wfProfileOut( __METHOD__ );
				return;
			}

			if ( !$helper->isScheduledForClosure( $user ) ) {
				$this->success = false;
				$this->resultMessage = $this->msg( 'closemyaccount-reactivate-error-not-scheduled' )->escaped();
				wfProfileOut( __METHOD__ );
				return;
			}

			if ( $user->checkPassword( $this->password ) ) {
				$this->wg->User = $user;
				$this->wg->User->setCookies();
				LoginForm::clearLoginToken();
				$userLoginHelper->clearPasswordThrottle( $this->username );

				$helper->reactivateAccount( $user );
				unset( $_SESSION['closeAccountSessionId'] );

				$userPageTitle = $user->getUserPage();
				$this->getOutput()->redirect( $userPageTitle->getFullURL() );
			} else {
				$this->success = false;
				$this->resultMessage = $this->msg( 'userlogin-error-wrongpassword' )->escaped();
				$this->errParam = 'password';
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Entry point for requesting that an account is reactivated
	 *
	 * This is the form users will be taken to after successfully attempting
	 * to login to an account that has requested closure.
	 *
	 * @return void
	 */
	public function reactivateRequest() {
		wfProfileIn( __METHOD__ );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$userId = $this->request->getSessionData( 'closeAccountSessionId' );
		$this->showForm = false;

		// Paranoia, if they got here, this shouldn't happen
		if ( $userId === null ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-id' )->escaped();
			wfProfileOut( __METHOD__ );
			return;
		}

		$helper = new CloseMyAccountHelper();

		$userObj = User::newFromId( $userId );

		if ( $helper->isClosed( $userObj ) ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-disabled' )->parse();
			wfProfileOut( __METHOD__ );
			return;
		}

		// Paranoia, shouldn't happen, but just in case...
		if ( !$helper->isScheduledForClosure( $userObj ) ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-not-scheduled' )->escaped();
			wfProfileOut( __METHOD__ );
			return;
		}

		if ( !$userObj->isEmailConfirmed() ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-email' )->parse();
			wfProfileOut( __METHOD__ );
			return;
		}

		$this->getOutput()->setPageTitle( $this->msg( 'closemyaccount-reactivate-page-title' )->plain() );

		if ( $this->request->wasPosted() ) {
			$result = $helper->requestReactivation( $userObj );

			if ( $result ) {
				$this->introText = $this->msg( 'closemyaccount-reactivate-requested' )->parseAsBlock();
			} else {
				$this->error = $this->msg( 'closemyaccount-reactivate-error-failed' )->parse();
			}
		} else {
			$this->showForm = true;

			// Show how many days they have before their account is permanently closed
			$daysUntilClosure = $helper->getDaysUntilClosure( $userObj );

			$this->introText = $this->msg( 'closemyaccount-reactivate-intro', $this->getLanguage()->formatNum( $daysUntilClosure ) )->parseAsBlock();

			$buttonParams = [
				'type' => 'button',
				'vars' => [
					'type' => 'submit',
					'classes' => [ 'wikia-button', 'big', 'closemyaccount' ],
					'value' => $this->msg( 'closemyaccount-reactivate-button-text' )->text(),
					'data' => [],
				]
			];

			$this->submitButton = \Wikia\UI\Factory::getInstance()->init( 'button' )->render( $buttonParams );
		}

		wfProfileOut( __METHOD__ );
	}

	public function email() {
		$this->language = $this->getVal( 'language' );
		$this->greeting = $this->msg( 'closemyaccount-reactivation-email-greeting' )->inLanguage( $this->language )->text();
		$this->content = $this->msg( 'closemyaccount-reactivation-email-content' )->inLanguage( $this->language )->text();
		$this->signature = $this->msg( 'closemyaccount-reactivation-email-signature' )->inLanguage( $this->language )->text();
	}

}
