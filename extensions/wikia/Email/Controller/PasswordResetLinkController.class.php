<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Fatal;

/**
 * Class PasswordResetLinkController
 *
 * @requestParam int targetUserId : The user id to send the password reset link email to
 * @requestParam string token : The token by which a user will be identified
 *
 * @package      Email\Controller
 */
class PasswordResetLinkController extends EmailController {

	protected $token;

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

	public function initEmail() {
		$this->token = $this->request->getVal( 'token' );

		if ( empty( $this->token ) ) {
			throw new Fatal( 'Required token has been left empty' );
		}
	}

	public function getSubject() {
		return $this->getMessage( 'emailext-password-subject' )->text();
	}

	/**
	 * @template passwordResetLink
	 */
	public function body() {
		$this->response->setData( [
			'salutation'    => $this->getSalutation(),
			'summary'       => $this->getSummary(),
			'passwordIntro' => $this->getIntro(),
			'resetLink'     => $this->getResetLink(),
			'instructions'  => $this->getMessage( 'emailext-password-unrequested' )->text(),
			'questions'     => $this->getMessage( 'emailext-password-questions' )->parse(),
			'signature'     => $this->getMessage( 'emailext-password-signature' )->text(),
		] );
	}

	protected function getResetLink() {
		return sprintf( 'http://dummy-address/%s/%s', $this->getTargetUserName(), $this->token );
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-password-reset-link-summary' )->text();
	}

	protected function getIntro() {
		return $this->getMessage( 'emailext-password-reset-link-intro' )->text();
	}
}
