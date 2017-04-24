<?php

/**
 * UserSignup Special Page
 * @author Hyun
 * @author Saipetch
 *
 */
class UserSignupSpecialController extends WikiaSpecialPageController {

	/** @var UserLoginHelper */
	private $userLoginHelper = null;

	public function __construct() {
		parent::__construct( 'UserSignup', '', false );
	}

	public function init() {
		$this->userLoginHelper = new UserLoginHelper();
	}

	/**
	 */
	public function index() {
		$this->redirectToAuthPages();
	}

	public function signupForm() {
		$this->redirectToAuthPages();
	}

	public function handleSignupFormSubmit() {
		$this->redirectToAuthPages();
	}

	public function captcha() {
	}

	public function signup() {
		$this->redirectToAuthPages();
	}

	/**
	 * @brief renders content in modal dialog
	 * @details
	 * @requestParam string username
	 */
	public function getEmailConfirmationMarketingModal() {
		$this->redirectToAuthPages();
	}

	public function sendConfirmationEmail() {
		$this->redirectToAuthPages();
	}


	public function changeUnconfirmedUserEmail() {
		$this->redirectToAuthPages();
	}

	public function formValidation() {
		$this->redirectToAuthPages();
	}


	private function redirectToAuthPages() {
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
		$newSignupPageUrl = '/register?redirect=' . $this->userLoginHelper->getRedirectUrl();
		$contentLangCode = $this->app->wg->ContLang->getCode();

		if ( $contentLangCode !== 'en' ) {
			$newSignupPageUrl .= '&uselang=' . $contentLangCode;
		}

		$this->getOutput()->redirect( $newSignupPageUrl );
	}

}
