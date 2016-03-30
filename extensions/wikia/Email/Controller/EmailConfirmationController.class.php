<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Check;

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
	 * A redefinition of our parent's assertCanEmail which removes assertions:
	 *
	 * - assertUserWantsEmail : Even if a user says they don't want email, they should get this
	 * - assertEmailIsConfirmed : Even if a user hasn't confirmed their email address, they should get this
	 * - assertUserNotBlocked : Even if a user is blocked they should still get these emails
	 *
	 * @throws \Email\Fatal
	 */
	public function assertCanEmail() {
		$this->assertUserHasEmail();
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
	const TYPE = "ConfirmationMail";

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

	private $newEmail;

	public function initEmail() {
		parent::initEmail();

		$this->newEmail = $this->request->getVal( 'newEmail' );
		$this->assertValidChangedParams();
	}

	protected function assertValidChangedParams() {
		if ( empty( $this->newEmail ) ) {
			throw new Check( "A value must be passed for parameter 'newEmail'" );
		}
	}

	protected function getTargetUserEmail() {
		return $this->newEmail;
	}

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

	protected static function getEmailSpecificFormFields() {
		$parentForm = parent::getEmailSpecificFormFields();

		$parentForm['inputs'][] = [
			'type' => 'text',
			'name' => 'newEmail',
			'label' => "New Email",
			'tooltip' => "The user's new email",
		];

		return $parentForm;
	}
}

class ReactivateAccountController extends AbstractEmailConfirmationController {

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
