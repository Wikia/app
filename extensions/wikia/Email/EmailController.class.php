<?php

namespace Email;

abstract class EmailController extends \WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/** @var \User The user associated with the current request */
	protected $currentUser;

	/** @var \User The user this email will be sent to */
	protected $targetUser;

	/** @var bool Whether or not to actuall send an email */
	protected $test;

	/**
	 * Since the children of this class are located in the 'Controller' directory, the default
	 * location for the template directory would be 'Controller/templates'.  Redefine it to be
	 * at the root of this extension instead.
	 *
	 * @return string
	 */
	public static function getTemplateDir() {
		return dirname( __FILE__ ) . '/templates';
	}

	public function init() {
		$this->currentUser = $this->getRequest()->getVal( 'currentUser', $this->wg->User );
		$this->targetUser = $this->getRequest()->getVal( 'targetUser', $this->wg->User );
		$this->test = $this->getRequest()->getVal( 'test', false );
	}

	/**
	 * This is the main entry point for the email extension.  The template set for this
	 * method is used for testing only, to preview the email that will be sent.
	 *
	 * @template Email_preview
	 *
	 * @return bool
	 *
	 * @throws \MWException
	 */
	public function handle() {
		try {
			$this->assertCanEmail();

			$toAddress = $this->getToAddress();
			$fromAddress = $this->getFromAddress();
			$replyToAddress = $this->getReplyToAddress();
			$subject = $this->getSubject();
			$body = $this->getBody();

			if ( !$this->test ) {
				\UserMailer::send( $toAddress, $fromAddress, $subject, $body, $replyToAddress );
			}
		} catch ( ControllerException $e ) {
			return $this->setErrorResponse( $e );
		}

		$this->response->setData( [
			'result' => 'ok',
			'subject' => $subject,
			'body' => $body,
		] );

		return true;
	}

	/**
	 * Create an error response for any exception thrown while creating this email
	 *
	 * @param ControllerException $e
	 *
	 * @return bool
	 */
	protected function setErrorResponse( ControllerException $e ) {
		$this->response->setData( [
			'result' => $e->errorType,
			'msg' => $e->getMessage(),
		] );
		return true;
	}

	protected function getTargetLang() {
		return $this->targetUser->getOption( 'language' );
	}

	/**
	 * Returns the address for the recipient of this email
	 *
	 * @return \MailAddress
	 */
	protected function getToAddress() {
		$to = new \MailAddress( $this->targetUser->getEmail(), $this->targetUser->getName() );
		return $to;
	}

	/**
	 * Returns the address for the sender of this email
	 *
	 * @return \MailAddress
	 */
	protected function getFromAddress() {
		$sender = new \MailAddress( $this->wg->PasswordSender, $this->wg->PasswordSenderName );
		return $sender;
	}

	/**
	 * Get the 'reply-to' address for the send of this email, if different than the 'from' address.
	 *
	 * @return \MailAddress|null
	 */
	protected function getReplyToAddress() {
		$replyAddr = null;
		if ( !empty( $this->wg->NoReplyAddress ) ) {
			$name = wfMessage('emailext-no-reply-name' )->escaped();
			$replyAddr = new \MailAddress( $this->wg->NoReplyAddress, $name );
		}

		return $replyAddr;
	}

	/**
	 * Return the subject used for this email
	 */
	abstract protected function getSubject();

	/**
	 * Renders the 'body' view of the current email controller
	 *
	 * @return string
	 */
	protected function getBody() {
		$html = $this->app->renderView(
			get_class( $this ),
			'body',
			$this->request->getParams()
		);
		return $html;
	}

	/**
	 * A basic check to see if we should send this email or not
	 *
	 * @throws Check
	 */
	public function assertCanEmail() {
		$this->assertUserWantsEmail();
		$this->assertUserNotBlocked();
	}

	/**
	 * @param $user
	 *
	 * @throws Fatal
	 */
	public function assertValidUser( $user ) {
		if ( !$user instanceof \User ) {
			throw new Fatal( wfMessage('emailext-error-not-user' )->escaped() );
		}

		if ( $user->getId() == 0 ) {
			throw new Fatal( wfMessage( 'emailext-error-empty-user' )->escaped() );
		}
	}

	/**
	 * @throws Fatal
	 */
	public function assertUserHasEmail() {
		$email = $this->targetUser->getEmail();
		if ( empty( $email ) ) {
			throw new Fatal( wfMessage( 'emailext-noemail' )->escaped() );
		}
	}

	/**
	 * @throws Fatal
	 */
	public function assertHasIP() {
		$ip = $this->getContext()->getRequest()->getIP();
		if ( !$ip ) {
			throw new Fatal( wfMessage( 'badipaddress' )->escaped() );
		}
	}

	/**
	 * This checks the 'unsubscribed' user option which is linked to the 'Disable all emails from Wikia'
	 * email preference
	 *
	 * @throws Check
	 */
	public function assertUserWantsEmail() {
		if ( $this->currentUser->getBoolOption('unsubscribed') ) {
			throw new Check( wfMessage('emailext-error-no-emails')->escaped() );
		}
	}

	/**
	 * This checks to see if the current user is blocked
	 *
	 * @throws Check
	 */
	public function assertUserNotBlocked() {
		if ( $this->currentUser->isBlocked() ) {
			throw new Check( wfMessage('emailext-error-user-blocked')->escaped() );
		}
	}
}
