<?php

namespace Email;


class SpecialSendEmailController extends \WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const REQUIRED_PERMISSION = "staff";

	public function __construct() {
		parent::__construct( 'SendEmail', '', $listed = false );
	}

	/**
	 * Run before index. First make sure the user can access page, then set the title and
	 * add the css.
	 */
	public function init() {
		$this->assertCanAccess();
		$this->setTitle();
		$this->addCss();
	}

	/**
	 * Makes sure the current user is staff and can therefore access this page. If not, display
	 * a permission error page.
	 * @throws \PermissionsError
	 */
	private function assertCanAccess() {
		if ( !$this->wg->User->isStaff() ) {
			throw new \PermissionsError( self::REQUIRED_PERMISSION );
		}
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
			$result = $this->processForm();
			$this->addBannerNotification( $result );
		}

		$this->response->setVal(
			"forms", $this->getForms()
		);
	}

	/**
	 * If a form was posted, dispatch the form to the proper Email Controller.
	 * @return \WikiaResponse
	 */
	private function processForm() {
		$params = $this->request->getParams();
		$controllerName = $params['emailController'];
		return \F::app()->sendRequest( $controllerName, 'handle', $params );
	}

	/**
	 * After the forms is sent to the proper Email Controller, inspect the result.
	 * If it's "ok", add a confirmation banner notification to indicate success. Otherwise
	 * add an error banner notification and output the error from the Email Controller.
	 * @param \WikiaResponse $result
	 */
	private function addBannerNotification( $result ) {
		$responseData = $result->getData();
		if ( $responseData['result'] == 'ok' ) {
			\BannerNotificationsController::addConfirmation(
				"Successfully sent email!",
				\BannerNotificationsController::CONFIRMATION_CONFIRM );
		} else {
			\BannerNotificationsController::addConfirmation(
				"Errors: " . $responseData['msg'],
				\BannerNotificationsController::CONFIRMATION_ERROR );
		}
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
			if ( preg_match( "/^Email\\\\Controller\\\\.+Controller$/", $className, $matches ) ) {
				$emailControllerClasses[] = $matches[0];
			}
		}

		return $emailControllerClasses;
	}

	/**
	 * Get the actual html form for the Email Controller. Each Email Controller implements a method
	 * which returns it's required inputs as an array. These get sent to the WikiaStyleGuideFormController
	 * which will construct the actual form.
	 * @param \Email\EmailController $controllerClass
	 * @return string
	 */
	private function getFormHtml( $controllerClass ) {
		return \F::app()->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $controllerClass::getAdminForm() ] );

	}
}
