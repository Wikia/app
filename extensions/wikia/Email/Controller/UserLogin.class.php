<?php

namespace Email\Controller;

use Email\Check;
use Email\Fatal;
use Email\EmailController;

class ForgotPasswordController extends EmailController {

	public function init() {
		parent::init();

		// @todo handle exceptions here
		// Set the recipient user
		$this->setTargetUser();
	}

	public function assertCanEmail() {
		parent::assertCanEmail();

		$this->assertCanChangePassword();
		$this->assertPasswordReminderNotThrottled();
		$this->assertUserHasEmail();
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
			throw new Fatal( wfMessage( 'emailext-error-reset-pass-forbidden' )->escaped() );
		}
	}

	protected function setTargetUser() {
		$username = $this->getRequest()->getVal( 'username' );

		if ( is_null( $username ) ) {
			throw new Fatal( wfMessage( 'emailext-error-noname' )->escaped() );
		}

		$user = \User::newFromName( $username );
		$this->assertValidUser( $user );

		$this->targetUser = $user;
	}

	protected function assertPasswordReminderNotThrottled() {
		if ( $this->targetUser->isPasswordReminderThrottled() ) {
			$key = 'emailext-error-throttled-mailpassword';
			$param = $this->wg->PasswordReminderResendTime;

			throw new Check( wfMessage( $key, $param )->escaped() );
		}
	}
}
