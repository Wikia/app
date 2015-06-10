<?php

namespace Email\Controller;

use Email\EmailController;

abstract class AbstractEmailConfirmationController extends EmailController {

	const LAYOUT_CSS = "confirmationEmail.css";

	private $confirmUrl;

	public function initEmail() {
		$this->confirmUrl = $this->request->getVal( 'confirmUrl' );
	}

	/**
	 * @template emailConfirmation
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'buttonLink' => $this->confirmUrl,
			'buttonText' => 'Confirmation Link',
			'contentFooterMessages' => $this->getContentFooterMessages()
		] );
	}

	abstract protected  function getSummary();

	protected function getContentFooterMessages() {
		$commonFooterMessage = $this->getCommonFooterMessages();
		$emailSpecificFooterMessages = $this->getEmailSpecificFooterMessages();
		return array_merge( $commonFooterMessage, $emailSpecificFooterMessages );
	}

	private function getCommonFooterMessages() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-community-team' )->text()
		];
	}

	abstract protected function getEmailSpecificFooterMessages();
}

class EmailConfirmationController extends AbstractEmailConfirmationController {

	protected function getSubject() {
		return $this->getMessage( 'emailext-emailconfirmation-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-emailconfirmation-summary' )->text();
	}

	protected function getEmailSpecificFooterMessages() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-why-confirm' )->text(),
			$this->getMessage( 'emailext-emailconfirmation-cant-wait' )->text()
		];

	}
}

class EmailConfirmationReminderController extends AbstractEmailConfirmationController {

	protected function getSubject() {
		return $this->getMessage( 'emailext-emailconfirmation-reminder-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-emailconfirmation-reminder-summary' )->text();
	}

	protected function getEmailSpecificFooterMessages() {
		return [
			$this->getMessage( 'emailext-emailconfirmation-reminder-lose-username',
				$this->targetUser->getName() )->parse()
		];
	}
}
