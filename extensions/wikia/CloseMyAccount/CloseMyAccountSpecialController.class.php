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
	 * @requestParam  string token - User's edit token
	 * @responseParam string showForm - Whether or not to show the request form
	 * @responseParam string introText - The introductory text that explains the
	 *                                   CloseMyAccount process
	 * @responseParam string warning - Text of any warnings to show to the user
	 * @responseParam string currentUserMessage - Text to confirm the current user
	 *                                            details
	 * @responseParam string confirmationText - Text for the confirmation text box
	 * @responseParam string submitButton - The HTML for the submit button
	 * @return void
	 */
	public function index() {

		$user = $this->getUser();

		$this->specialPage->setHeaders();

		if ( $this->getPar() === 'reactivate' ) {
			$this->forward( 'CloseMyAccountSpecial', 'reactivate' );
			return;
		}

		if ( !$user->isLoggedIn() ) {
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

			$this->showForm = false;

			if ( $scheduleCloseAccount ) {
				$user->logout();
				$this->introText = $this->msg(
					'closemyaccount-scheduled',
					$this->getLanguage()->formatNum( CloseMyAccountHelper::CLOSE_MY_ACCOUNT_WAIT_PERIOD )
				)->parseAsBlock();
			} else {
				$this->introText = '';
				$this->warning = $this->msg( 'closemyaccount-scheduled-failed' )->parse();
			}

		} else {

			$this->introText = $this->msg( 'closemyaccount-intro-text', $waitPeriod, $user->getName() )->parseAsBlock();
			$this->currentUserMessage = $this->msg( 'closemyaccount-logged-in-as', $user->getName() )->parseAsBlock();

			if ( !$user->isEmailConfirmed() ) {
				$this->warning = $this->msg( 'closemyaccount-unconfirmed-email' )->parse();
			} else {
				$this->currentUserMessage .= $this->msg( 'closemyaccount-current-email',
					$user->getEmail(), $user->getName() )->parseAsBlock();
			}

			$this->confirmationText = $this->msg( 'closemyaccount-confirm', $user->getName() )->parse();

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
	 * @requestParam string code - The confirmation code for reactivating an account
	 * @requestParam string username - The user name of the account to reactivate
	 * @requestParam string password - The password for the account to reactivate
	 * @requestParam string editToken - The edit token for the current user
	 * @requestParam string loginToken - The login token for the current user
	 * @responseParam boolean success - Whether or not reactivation was successful
	 * @responseParam string resultMessage - The result of the form submission
	 * @responseParam string errParam - The form item an error is related to
	 * @return void
	 */
	public function reactivate() {

		$this->code = $this->getVal( 'code', false );
		$user = $this->getUser();

		if ( empty( $this->code ) ) {
			if ( $user->isLoggedIn() ) {
				$this->forward( __CLASS__, 'reactivateRequest' );
			} else {
				$this->success = false;
				$this->resultMessage = $this->msg( 'closemyaccount-reactivate-error-empty-code' )->parse();
			}
			return;
		}

		$this->getOutput()->setPageTitle( $this->msg( 'closemyaccount-reactivate-page-title' )->plain() );
		$this->response->addAsset( 'extensions/wikia/UserLogin/css/UserLogin.scss' );

		$helper = new CloseMyAccountHelper();

		if ( $user->isAnon() ) {
			$userLoginHelper = new UserLoginHelper();
			$this->getOutput()->redirect( $userLoginHelper->getNewAuthUrl( '/signin' ) );
			return;
		}

		$expUser = User::newFromConfirmationCode( $this->code );
		if ( !( $expUser instanceof User ) ) {
			$this->success = false;
			$this->resultMessage = $this->msg( 'closemyaccount-reactivate-error-invalid-code',
				$this->username )->parse();
			return;
		}

		$user = $this->getUser();
		if ( $user->getId() != $expUser->getId() ) {
			$this->success = false;
			$this->resultMessage = $this->msg( 'wikiaconfirmemail-error-user-not-match' )->parse();
			$this->errParam = 'username';
			return;
		}

		if ( $helper->isClosed( $user ) ) {
			$this->success = false;
			$this->resultMessage = $this->msg( 'closemyaccount-reactivate-error-disabled' )->parse();
			return;
		}

		if ( !$helper->isScheduledForClosure( $user ) ) {
			$this->success = false;
			$this->resultMessage = $this->msg( 'closemyaccount-reactivate-error-not-scheduled' )->escaped();
			return;
		}

		// call to User::newFromConfirmationCode() is basically a token check
		// tell CSRFDetector that we're fine here (PLATFORM-2206)
		\Wikia\Security\CSRFDetector::onUserMatchEditToken();

		$helper->reactivateAccount( $user );

		BannerNotificationsController::addConfirmation( $this->msg( 'closemyaccount-reactivate-success' )->escaped() );

		$userPageTitle = $user->getUserPage();
		$this->getOutput()->redirect( $userPageTitle->getFullURL() );
	}

	/**
	 * Entry point for requesting that an account is reactivated
	 *
	 * This is the form users will be taken to after successfully attempting
	 * to login to an account that has requested closure.
	 *
	 * @responseParam boolean showForm - Whether or not to show the request form
	 * @responseParam string error - Whether or not an error occurred
	 * @responseParam string introText - The introductory text that explains the
	 *                                   reactivation process
	 * @responseParam string submitButton - The HTML for the submit button
	 * @return void
	 */
	public function reactivateRequest() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		$this->showForm = false;

		// Paranoia, if they got here, this shouldn't happen
		if ( $this->getUser()->isAnon() ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-id' )->escaped();
			return;
		}

		$helper = new CloseMyAccountHelper();

		$user = $this->getUser();

		if ( $helper->isClosed( $user ) ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-disabled' )->parse();
			return;
		}

		// Paranoia, shouldn't happen, but just in case...
		if ( !$helper->isScheduledForClosure( $user ) ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-not-scheduled' )->escaped();
			return;
		}

		if ( !$user->isEmailConfirmed() ) {
			$this->error = $this->msg( 'closemyaccount-reactivate-error-email' )->parse();
			return;
		}

		$this->getOutput()->setPageTitle( $this->msg( 'closemyaccount-reactivate-page-title' )->plain() );


		$this->editToken = $user->getEditToken();

		if ( $this->request->wasPosted() && $user->matchEditToken( $this->getVal( 'token' ) ) ) {
			$result = $helper->requestReactivation( $user, $this->app );

			if ( $result ) {
				$this->introText = $this->msg( 'closemyaccount-reactivate-requested' )->parseAsBlock();
			} else {
				$this->error = $this->msg( 'closemyaccount-reactivate-error-failed' )->parse();
			}
		} else {
			$this->showForm = true;

			// Show how many days they have before their account is permanently closed
			$daysUntilClosure = $helper->getDaysUntilClosure( $user );

			$this->introText = $this->msg( 'closemyaccount-reactivate-intro',
				$this->getLanguage()->formatNum( $daysUntilClosure ), $user->getName() )->parseAsBlock();

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

	}
}
