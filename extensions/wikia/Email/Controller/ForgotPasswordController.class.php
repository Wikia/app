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
		$this->fromAddress = new \MailAddress(
			$this->wg->PasswordSender,
			$this->wg->PasswordSenderName
		);
	}

	public function assertCanEmail() {
		parent::assertCanEmail();

		$this->assertCanChangePassword();
		$this->assertPasswordReminderNotThrottled();
		$this->assertHasIP();
	}

	public function getSubject() {
		return wfMessage( 'emailext-password-email-subject' )->inLanguage( $this->targetLang )->text();
	}

	protected function getContent() {
		$html = $this->app->renderView(
			get_class( $this ),
			'body',
			$this->request->getParams()
		);

		return $html;
	}

	/**
	 * @template forgotPassword
	 *
	 * @throws \MWException
	 */
	public function body() {
		$targetUser = $this->targetUser;

		wfRunHooks( 'User::mailPasswordInternal', [
			$this->currentUser,
			$this->getContext()->getRequest()->getIP(),
			$targetUser,
		] );

		$tempPass = $targetUser->randomPassword();
		$targetUser->setNewpassword( $tempPass );
		$targetUser->saveSettings();

		$this->response->setData( [
			'greeting' => wfMessage( 'emailext-password-email-greeting', $targetUser->getName() )->inLanguage( $this->targetLang )->text(),
			'content' => wfMessage( 'emailext-password-email-content', $tempPass )->inLanguage( $this->targetLang )->text(),
			'signature' => wfMessage( 'emailext-password-email-signature' )->inLanguage( $this->targetLang )->text(),
		] );
	}

	protected function assertCanChangePassword() {
		if ( !$this->wg->Auth->allowPasswordChange() ) {
			throw new Fatal( 'This user is not allowed to change their password' );
		}
	}

	protected function assertPasswordReminderNotThrottled() {
		// Do not throttle staff
		if ( $this->wg->User->isStaff() ) {
			return;
		}

		if ( $this->targetUser->isPasswordReminderThrottled() ) {
			throw new Check( 'Too many resend password requests sent' );
		}
	}
}
