<?php

namespace Email\Controller;

use Email\EmailController;

/**
 * Class ForgotPasswordController
 *
 * @requestParam string username : The username to send the password reset email to
 *
 * @package Email\Controller
 */
class ForgotPasswordController extends EmailController {

	protected $tempPass;

	/**
	 * @see EmailController::assertCanAccessController
	 * @throws \Email\Fatal
	 */
	public function assertCanAccessController() {
		global $wgTheSchwartzSecretToken;

		$token = $this->getVal('secret');
		if( isset( $token ) && $token == $wgTheSchwartzSecretToken ) {
			return;
		}

		parent::assertCanAccessController();
	}

	/**
	 * A redefinition of our parent's assertCanEmail which removes assertions:
	 *
	 * - assertUserWantsEmail : Even if a user says they don't want email, they should get this
	 * - assertUserNotBlocked : Even if a user is blocked they should still get these emails
	 *
	 * @throws \Email\Fatal
	 */
	public function assertCanEmail() {
		$this->assertUserHasEmail();
	}

	public function initEmail() {
		$userService = new \UserService();
		$this->tempPass = $this->request->getVal( 'tempPass' );
		if ( empty( $this->tempPass ) ) {
			$this->tempPass = $userService->resetPassword( $this->targetUser );
		}
	}

	public function getSubject() {
		return $this->getMessage( 'emailext-password-subject' )->text();
	}

	/**
	 * @template temporaryPassword
	 */
	public function body() {
		$this->response->setData( [
			'salutation' => $this->getSalutation(),
			'summary' => $this->getSummary(),
			'passwordIntro' => $this->getIntro(),
			'tempPassword' => $this->tempPass,
			'instructions' => $this->getMessage( 'emailext-password-unrequested' )->text(),
			'questions' => $this->getMessage( 'emailext-password-questions' )->parse(),
			'signature' => $this->getMessage( 'emailext-password-signature' )->text(),
		] );
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-password-summary' )->text();
	}

	protected function getIntro() {
		return $this->getMessage( 'emailext-password-intro' )->text();
	}

	protected function getDetails() {
		return $this->getMessage( 'emailext-password-details' )->text();
	}
}
