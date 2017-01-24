<?php

namespace Email\Controller;

/**
 * Class FacebookDisconnectController
 *
 * @requestParam int targetUserId : The user id to send the password reset link email to
 * @requestParam string reset_token : The token by which a user will be identified
 * @requestParam string return_url : The url user will be redirected to after setting a password
 *
 * @package      Email\Controller
 */
class FacebookDisconnectController extends PasswordResetLinkController {

	public function getSubject() {
		return $this->getMessage( 'emailext-fbdisconnect-subject' )->text();
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-fbdisconnect-summary' )->text();
	}

	protected function getIntro() {
		return $this->getMessage( 'emailext-fbdisconnect-intro' )->text();
	}

	protected function getInstructions() {
		return $this->getMessage( 'emailext-fbdisconnect-instructions' )->text();
	}
}

