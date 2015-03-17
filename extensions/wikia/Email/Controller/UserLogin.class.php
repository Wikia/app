<?php

namespace Email\Controller;

use Email\Check;
use Email\Fatal;
use Email\EmailController;

/**
 * Class ForgotPasswordController
 *
 * @requestParam string username : The username to send the password reset email to
 *
 * @package Email\Controller
 */
class ForgotPasswordController extends EmailController {

	public function initEmail() {
		// Set the recipient user
		$this->setTargetUser();
	}

	public function assertCanEmail() {
		parent::assertCanEmail();

		$this->assertCanChangePassword();
		$this->assertPasswordReminderNotThrottled();
		$this->assertHasIP();
	}

	protected function getSubject() {
		$lang = $this->getTargetLang();
		return wfMessage( 'emailext-password-email-subject' )->inLanguage( $lang )->text();
	}

	/**
	 * @template ForgotPassword_body
	 *
	 * @throws \MWException
	 */
	public function body() {
		$targetUser = $this->targetUser;
		$lang = $this->getTargetLang();

		wfRunHooks( 'User::mailPasswordInternal', [
			$this->currentUser,
			$this->getContext()->getRequest()->getIP(),
			$targetUser,
		] );

		$tempPass = $targetUser->randomPassword();
		$targetUser->setNewpassword( $tempPass );
		$targetUser->saveSettings();

		$this->response->setData( [
			'greeting' => wfMessage( 'emailext-password-email-greeting', $targetUser->getName() )->inLanguage( $lang )->text(),
			'content' => wfMessage( 'emailext-password-email-content', $tempPass )->inLanguage( $lang )->text(),
			'signature' => wfMessage( 'emailext-password-email-signature' )->inLanguage( $lang )->text(),
		] );
	}

	protected function assertCanChangePassword() {
		if ( !$this->wg->Auth->allowPasswordChange() ) {
			throw new Fatal( wfMessage( 'emailext-error-password-reset-forbidden' )->escaped() );
		}
	}

	protected function setTargetUser() {
		$username = $this->getRequest()->getVal( 'username' );
		$this->targetUser = $this->getUserFromName( $username );
	}

	protected function assertPasswordReminderNotThrottled() {
		// Do not throttle staff
		if ( $this->wg->User->isStaff() ) {
			return;
		}

		if ( $this->targetUser->isPasswordReminderThrottled() ) {
			$key = 'emailext-error-password-throttled';
			$param = $this->wg->PasswordReminderResendTime;

			throw new Check( wfMessage( $key, $param )->escaped() );
		}
	}
}
