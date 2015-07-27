<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Check;
use Email\Tracking\TrackingCategories;

abstract class AbstractEmailConfirmationController extends EmailController {

	const LAYOUT_CSS = EmailController::NO_ADDITIONAL_STYLES;

	private $confirmUrl;

	public function initEmail() {
		$this->confirmUrl = $this->request->getVal( 'confirmUrl' );
		$this->assertValidParams();
	}

	protected function assertValidParams() {
		if ( empty( $this->confirmUrl ) ) {
			throw new Check( "Must pass value for confirmUrl" );
		}
	}

	/**
	 * @template emailConfirmation
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'buttonLink' => $this->confirmUrl,
			'buttonText' => $this->getButtonText(),
			'contentFooterMessages' => $this->getContentFooterMessages()
		] );
	}

	abstract protected function getSummary();

	protected function getButtonText() {
		return $this->getMessage( 'emailext-emailconfirmation-button-text' )->text();
	}

	protected function getContentFooterMessages() {
		$commonFooterMessage = $this->getCommonFooterMessages();
		$emailSpecificFooterMessages = $this->getEmailSpecificFooterMessages();
		return array_merge( $emailSpecificFooterMessages, $commonFooterMessage );
	}

	private function getCommonFooterMessages() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-community-team' )->text()
		];
	}

	abstract protected function getEmailSpecificFooterMessages();

	protected static function getEmailSpecificFormFields() {
			$form = [
				'inputs' => [
					[
						'type' => 'hidden',
						'name' => 'confirmUrl',
						'value' => "#",
					],
				]
			];

			return $form;

	}
}

class EmailConfirmationController extends AbstractEmailConfirmationController {

	const TRACKING_CATEGORY = TrackingCategories::EMAIL_CONFIRMATION;

	protected function getSubject() {
		return $this->getMessage( 'emailext-emailconfirmation-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-emailconfirmation-summary' )->text();
	}

	protected function getEmailSpecificFooterMessages() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-footer-1' )->text(),
			$this->getMessage( 'emailext-emailconfirmation-footer-2' )->text()
		];

	}
}

class EmailConfirmationReminderController extends AbstractEmailConfirmationController {

	const TRACKING_CATEGORY = TrackingCategories::EMAIL_CONFIRMATION_REMINDER;

	protected function getSubject() {
		return $this->getMessage( 'emailext-emailconfirmation-reminder-subject', $this->getTargetUserName() )->parse();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-emailconfirmation-reminder-summary' )->text();
	}

	protected function getEmailSpecificFooterMessages() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-reminder-footer-1',
				$this->getTargetUserName() )->parse()
		];
	}
}

class ConfirmationChangedEmailController extends AbstractEmailConfirmationController {

	const TRACKING_CATEGORY = TrackingCategories::CHANGED_EMAIL_CONFIRMATION;

	protected function getSubject() {
		return $this->getMessage( 'emailext-emailconfirmation-changed-subject' )->text();
	}

	protected  function getSummary() {
		return $this->getMessage( 'emailext-emailconfirmation-changed-summary' )->text();
	}

	protected function getEmailSpecificFooterMessages() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-changed-footer-1' )->text(),
			$this->getMessage( 'emailext-emailconfirmation-changed-footer-2' )->text(),
		];
	}
}

class ReactivateAccountController extends AbstractEmailConfirmationController {

	const TRACKING_CATEGORY = TrackingCategories::REACTIVATE_ACCOUNT;

	protected function getSubject() {
		return $this->getMessage( 'emailext-reactivate-account-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-reactivate-account-summary' )->text();
	}

	protected function getButtonText() {
		return $this->getMessage( 'emailext-reactivate-account-button-text' )->text();
	}

	protected function getEmailSpecificFooterMessages() {
		return [
			$this->getMessage( 'emailext-reactivate-account-welcome-back' )->text(),
		];
	}
}
