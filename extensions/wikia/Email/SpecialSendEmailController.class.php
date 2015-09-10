<?php

namespace Email;

class SpecialSendEmailController extends \WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const PAGE_NAME = "SendEmail";

	public function __construct() {
		parent::__construct( self::PAGE_NAME, '', $listed = false );
	}

	/**
	 * Run before index. First make sure the user can access page, then set the title, disable
	 * redirects, and add the css.
	 */
	public function init() {
		$this->assertCanAccess();
		$this->disableRedirects();
		$this->setTitle();
		$this->addCss();
	}

	/**
	 * Makes sure the current user is staff and can therefore access this page. If not, display
	 * a permission error page.
	 * @throws \PermissionsError
	 */
	private function assertCanAccess() {
		if ( !Helper::userCanAccess() ) {
			throw new \PermissionsError( Helper::REQUIRED_USER_RIGHT );
		}
	}

	/**
	 * Disable redirects. Some operations called in the controllers will cause the page to
	 * redirect (eg Article::newFromTitle()). We always want to return to Special:SendEmail.
	 */
	private function disableRedirects() {
		$this->wg->Out->enableRedirects( false );
	}

	/**
	 * Set's the <h1> and <title> tags, and suppresses the generic "Special Page" subtitle.
	 */
	private function setTitle() {
		$this->getContext()->getOutput()->setHTMLTitle( "Special Send Email" );
		$this->getContext()->getOutput()->setPageTitle( "Special Send Email" );
		$this->wg->SupressPageSubtitle = true;
	}

	/**
	 * Adds stylesheet to output
	 */
	private function addCss() {
		$this->response->addAsset( 'special_email_admin_css' );
	}

	/**
	 * @template specialSendEmail
	 */
	public function index() {
		if ( $this->wg->request->wasPosted() ) {
			if ( $this->editTokenValidates() ) {
				$result = $this->processForm();
				$this->addBannerNotificationFromResult( $result );
			} else {
				$this->addErrorBannerNotification( 'Invalid edit token' );
			}
		}

		$this->response->setVal( 'forms', $this->getForms() );
	}

	/**
	 * Makes sure the form contains a valid CSRF token
	 * @return bool
	 */
	private function editTokenValidates() {
		return $this->wg->User->matchEditToken( $this->request->getVal( 'token' ) );
	}

	/**
	 * If a form was posted, dispatch the form to the proper Email Controller.
	 * @return \WikiaResponse
	 */
	private function processForm() {
		$postedFormValues = $this->request->getParams();
		$controllerName = $postedFormValues['emailController'];
		return \F::app()->sendRequest( $controllerName, 'handle', $postedFormValues );
	}

	/**
	 * After the forms is sent to the proper Email Controller, inspect the result.
	 * If it's "ok", add a confirmation banner notification to indicate success. Otherwise
	 * add an error banner notification and output the error from the Email Controller.
	 * @param \WikiaResponse $result
	 */
	private function addBannerNotificationFromResult( $result ) {
		$responseData = $result->getData();
		if ( $responseData['result'] == 'ok' ) {
			$this->addSuccessBannerNotification( "Successfully sent email!" );
		} else {
			$this->addErrorBannerNotification( $responseData['msg'] );
		}
	}

	private function addSuccessBannerNotification( $msg ) {
		\BannerNotificationsController::addConfirmation(
			$msg,
			\BannerNotificationsController::CONFIRMATION_CONFIRM
		);
	}

	private function addErrorBannerNotification( $msg ) {
		\BannerNotificationsController::addConfirmation(
			"Errors: " . $msg,
			\BannerNotificationsController::CONFIRMATION_ERROR
		);
	}

	/**
	 * Get all of the forms for the Special:SendEmail page. Each of these forms
	 * will have all the inputs required to send off each of our emails.
	 * @return array
	 */
	private function getForms() {
		$forms = [];
		foreach ( $this->getEmailControllerClasses() as $emailControllerClass ) {
			$forms[] = $this->getFormHtml( $emailControllerClass );
		}

		return $forms;
	}

	/**
	 * Get a list of all of our Email Controller classes. Each of these controller
	 * classes represents one of the types of emails that we send.
	 * @return array
	 */
	public function getEmailControllerClasses() {
		$allClasses = \F::app()->wg->AutoloadClasses;
		$emailControllerClasses = [];
		foreach ( $allClasses as $className => $classPath ) {
			if ( preg_match( EmailController::EMAIL_CONTROLLER_REGEX, $className, $matches ) ) {
				if ( !$this->isClassAbstract( $className ) ) {
					$emailControllerClasses[] = $matches[0];
				}
			}
		}

		return $emailControllerClasses;
	}

	/**
	 * Checks if the given class is abstract or not. We only want concrete classes when
	 * creating the forms for Special:SendEmail. The abstract classes these concrete
	 * classes inherit from create forms which throw fatals when submitted.
	 * @param $className
	 * @return bool
	 */
	public function isClassAbstract( $className ) {
		$reflectionClass = new \ReflectionClass( $className );
		return $reflectionClass->isAbstract();
	}

	/**
	 * Get the actual HTML form for the Email Controller. Each Email Controller implements a method
	 * which returns it's required inputs as an array. These get sent to the WikiaStyleGuideFormController
	 * which will construct the actual form.
	 * @param \Email\EmailController $controllerClass
	 * @return string
	 */
	private function getFormHtml( $controllerClass ) {
		$form = $controllerClass::getAdminForm();
		if ( $this->isThePostedForm( $controllerClass ) ) {
			$form = $this->populateFormWithPostedValues( $form );
		}

		return \F::app()->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $form ] );
	}

	/**
	 * Checks if the current request contains a POSTed form and, if so, if that form
	 * corresponds to the given controller class.
	 * @param $controllerClass
	 * @return bool
	 */
	private function isThePostedForm( $controllerClass ) {
		if ( !$this->wg->request->wasPosted() ) {
			return false;
		}

		$postedFormValues = $this->request->getParams();
		return $controllerClass == $postedFormValues['emailController'];
	}

	/**
	 * Populates a given form with values POSTed by the client. This will allow the
	 * form to be re-rendered with the values inputed by the user, so they can make
	 * changes without having to re-enter all of the form fields again.
	 * @param $form
	 * @return mixed
	 */
	private function populateFormWithPostedValues( $form ) {
		$postedFormValues = $this->request->getParams();
		foreach ( $form['inputs'] as &$input ) {
			$inputName = $input['name'];
			if ( array_key_exists( $inputName, $postedFormValues ) ) {
				$input['value'] = $postedFormValues[$inputName];
			}
		}

		return $form;
	}
}
