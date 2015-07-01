<?php

namespace Email\Controller;

use Email\EmailController;
//use Email\Check;
use Email\Tracking\TrackingCategories;

class FacebookDisconnectController extends ForgotPasswordController {
	const TRACKING_CATEGORY = TrackingCategories::TEMPORARY_PASSWORD;

	public function getSubject() {
		return $this->getMessage( 'emailext-fbdisconnect-subject' )->text();
	}

	/**
	 * @template forgotPassword
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'passwordIntro' => $this->getIntro(),
			'tempPassword' => $this->getMessage( 'emailext-fbdisconnect-username-password',
					$this->targetUser->getName(),
					$this->tempPass
				)->parse(),
			'unrequested' => $this->getMessage( 'emailext-fbdisconnect-unrequested' )->text(),
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

