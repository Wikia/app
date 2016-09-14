<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Check;

class EmailConfirmationController extends EmailController {

	const TYPE = "ConfirmationMail";

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

	protected function getSubject() {
		return $this->getMessage( 'emailext-emailconfirmation-subject' )->text();
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
			'contentFooterMessageTop' => $this->getContentFooterMessageTop(),
			'contentFooterList' => $this->createContentFooterList(),
			'contentFooterMessagesBottom' => $this->getContentFooterMessagesBottom(),
			'signature' => $this->getMessage( 'emailext-emailconfirmation-community-team' )->text()
		] );
	}

	private function getSummary() {
		return $this->getMessage( 'emailext-emailconfirmation-summary' )->text();
	}

	private function getButtonText() {
		return $this->getMessage( 'emailext-emailconfirmation-button-text' )->text();
	}

	private function getContentFooterMessageTop() {
		return $this->getMessage( 'emailext-emailconfirmation-footer-1' )->text();
	}

	private function createContentFooterList() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-footer-list-1' )->text(),
			$this->getMessage( 'emailext-emailconfirmation-footer-list-2' )->text(),
			$this->getMessage( 'emailext-emailconfirmation-footer-list-3' )->text(),
			$this->getMessage( 'emailext-emailconfirmation-footer-list-4' )->text(),
		];
	}

	private function getContentFooterMessagesBottom() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-footer-2' )->text()
		];
	}

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