<?php

namespace Email\Controller;

use Email\EmailController;
use Email\Fatal;
use RequestContext;
use WikiFactory;

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
	protected $returnUrl;
	const MAX_LINK_LENGTH = 40;

	const RESET_URL = 'https://www.wikia.com/resetpassword';

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
		$this->token = $this->request->getVal( 'reset_token' );
		$this->returnUrl = $this->request->getVal( 'return_url' );

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
		$currentIp = $this->getContext()->getRequest()->getIP();
		wfRunHooks( 'User::mailPasswordInternal', [
			$this->currentUser,
			$currentIp,
			$this->targetUser,
			WikiFactory::IDtoDB( WikiFactory::COMMUNITY_CENTRAL ),
		] );

		$url = $this->getResetLink();

		$this->response->setData( [
			'salutation'       => $this->getSalutation(),
			'summary'          => $this->getSummary(),
			'passwordIntro'    => $this->getIntro(),
			'resetLink'        => $url,
			'resetLinkCaption' => $this->getResetLinkCaption( $url ),
			'instructions'     => $this->getMessage( 'emailext-password-unrequested' )->text(),
			'questions'        => $this->getMessage( 'emailext-password-questions' )->parse(),
			'signature'        => $this->getMessage( 'emailext-password-signature' )->text(),
		] );
	}

	protected function getResetLink() {
		$query = [
			'username' => $this->getTargetUserName(),
			'token'    => $this->token,
		];

		if ( !empty( $this->returnUrl ) ) {
			$query['redirect'] = $this->returnUrl;
		}

		return wfAppendQuery( $this->getResetURL(), $query );
	}

	protected function getResetLinkCaption( $resetLink ) {
		return strlen( $resetLink ) > self::MAX_LINK_LENGTH
			? $this->getMessage( 'emailext-password-reset-link-link-caption' )->text()
			: $resetLink;
	}

	protected function getSummary() {
		return $this->getMessage( 'emailext-password-reset-link-summary' )->text();
	}

	protected function getIntro() {
		return $this->getMessage( 'emailext-password-reset-link-intro' )->text();
	}

	private function getResetURL() {
		global $wgDevelEnvironment;

		if ( !empty( $wgDevelEnvironment ) && !empty( $this->returnUrl ) ) {
			$parts = wfParseUrl( $this->returnUrl );
			if ( !empty( $parts ) &&
				preg_match( '/\.wikia-dev\.(com|us|pl)$/', $parts['host'] )
			) {
				return "{$parts['scheme']}://{$parts['host']}/resetpassword";
			}
		}

		return self::RESET_URL;
	}
}
