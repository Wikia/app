<?php

namespace Email;


class SpecialSendEmailController extends \WikiaSpecialPageController {

	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	public function __construct() {
		parent::__construct( 'SendEmail', $restriction = 'staff', $listed = false );
	}

	public function init() {
		$this->setTitle();
		$this->setRobotPolicy();
		$this->addCss();
	}

	private function assertCanAccess(){
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
		}
	}

	private function setTitle() {
		$this->getContext()->getOutput()->setHTMLTitle( "Special Email Admin" );
	}

	private function setRobotPolicy() {
		$this->getContext()->getOutput()->setRobotPolicy( "index,follow" );
	}

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
			//$this->response->redirect( $this->wg->Title->getFullURL() );
		} else {

		}

		$forms = $this->getForms();
		$this->response->setVal(
			"forms", $forms
		);
	}

	private function processForm() {
		$params = $this->request->getParams();
		$controllerName = $params['emailController'];
		return \F::app()->sendRequest( $controllerName, 'handle', $params );
	}

	/**
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

	private function getForms() {
		$forms = [];
		/** @var \Email\EmailController $emailControllerClass */
		foreach ( $this->getEmailControllerClasses() as $emailControllerClass ) {
			$forms[] = $this->getFormHtml( $emailControllerClass );
		}

		return $forms;
	}

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
	 * @param \Email\EmailController $controllerClass
	 * @return string
	 */
	private function getFormHtml( $controllerClass ) {
		return \F::app()->renderView( 'WikiaStyleGuideForm', 'index', [ 'form' => $controllerClass::getAdminForm() ] );

	}
}
