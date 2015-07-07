<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Tracking\TrackingCategories;

class FacebookDisconnectController extends ForgotPasswordController {
	public function getSubject() {
		return $this->getMessage( 'emailext-fbdisconnect-subject' )->text();
	}

	/**
	 * @template temporaryPassword
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'passwordIntro' => $this->getIntro(),
			'username' => $this->getMessage( 'emailext-fbdisconnect-username',
				$this->targetUser->getName() )->text(),
			'tempPassword' => $this->getMessage( 'emailext-fbdisconnect-password',
				$this->tempPass )->text(),
			'instructions' => $this->getMessage( 'emailext-fbdisconnect-instructions' )->text(),
			'questions' => $this->getMessage( 'emailext-password-questions' )->parse(),
			'signature' => $this->getMessage( 'emailext-password-signature' )->text(),
		] );
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-fbdisconnect-summary' )->text();
	}

	protected function getIntro() {
		return $this->getMessage( 'emailext-fbdisconnect-intro' )->text();
	}
}

