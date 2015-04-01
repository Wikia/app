<?php

namespace Email;

abstract class EmailController extends \WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = \WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/** @var \User The user associated with the current request */
	protected $currentUser;

	/** @var \User The user this email will be sent to */
	protected $targetUser;

	protected $hasErrorResponse = false;

	/** @var bool Whether or not to actually send an email */
	protected $test;

	/**
	 * Since the children of this class are located in the 'Controller' directory, the default
	 * location for the template directory would be 'Controller/templates'.  Redefine it to be
	 * at the root of this extension instead.
	 *
	 * @return string
	 */
	public static function getTemplateDir() {
		return dirname( __FILE__ ) . '/templates/compiled';
	}

	public function init() {
		try {
			$this->assertCanAccessController();

			$this->currentUser = $this->findUserFromRequest( 'currentUser', $this->wg->User );
			$this->targetUser = $this->findUserFromRequest( 'targetUser', $this->wg->User );
			$this->test = $this->getRequest()->getVal( 'test', false );

			$this->initEmail();
		} catch ( ControllerException $e ) {
			$this->setErrorResponse( $e );
		}
	}

	/**
	 * Make sure to only allow authorized use of this extension.
	 *
	 * @throws \Email\Fatal
	 */
	public function assertCanAccessController() {
		if ( $this->wg->User->isStaff() ) {
			return;
		}

		if ( $this->request->isInternal() ) {
			return;
		}

		throw new Fatal( wfMessage( 'emailext-error-restricted-controller' )->escaped() );
	}

	/**
	 * Allow child classes to set some initial values.  Added here so its always defined
	 * but is kept blank so does not need to be called via parent::initEmail()
	 */
	public function initEmail() {
		// Can be overridden in child class
	}

	/**
	 * This is the main entry point for the email extension.  The template set for this
	 * method is used for testing only, to preview the email that will be sent.
	 *
	 * @template emailPreview
	 *
	 * @throws \MWException
	 */
	public function handle() {
		// If something previously has thrown an error (likely 'init') don't continue
		if ( $this->hasErrorResponse ) {
			return;
		}

		try {
			$this->assertCanEmail();

			$toAddress = $this->getToAddress();
			$fromAddress = $this->getFromAddress();
			$replyToAddress = $this->getReplyToAddress();
			$subject = $this->getSubject();
			$body = [ 'html' => $this->getBody() ];

			if ( !$this->test ) {
				$status = \UserMailer::send(
					$toAddress,
					$fromAddress,
					$subject,
					$body,
					$replyToAddress
				);
				$this->assertGoodStatus( $status );
			}
		} catch ( ControllerException $e ) {
			$this->setErrorResponse( $e );
			return;
		}

		$this->response->setData( [
			'result' => 'ok',
			'subject' => $subject,
			'body' => $body['html'],
		] );
	}

	/**
	 * Render the main layout file
	 *
	 * @template main
	 */
	public function main() {
		$this->response->setVal( 'content', $this->getVal( 'content' ) );
		$this->response->setVal( 'footerMessages', $this->getVal( 'footerMessages' ) );
		$this->response->setVal( 'fancyHubLinks', true );
	}

	/**
	 * Create an error response for any exception thrown while creating this email
	 *
	 * @param ControllerException $e
	 *
	 */
	protected function setErrorResponse( ControllerException $e ) {
		$this->hasErrorResponse = true;
		$this->response->setData( [
			'result' => $e->getErrorType(),
			'msg' => $e->getMessage(),
		] );
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
			$name = wfMessage( 'emailext-no-reply-name' )->escaped();
			$replyAddr = new \MailAddress( $this->wg->NoReplyAddress, $name );
		}

		return $replyAddr;
	}

	/**
	 * Return the subject used for this email
	 * Must be overridden in child classes
	 */
	abstract function getSubject();

	/**
	 * Renders the 'body' view of the current email controller
	 *
	 * @return string
	 */
	protected function getBody() {
		$moduleBody = $this->app->renderView(
			get_class( $this ),
			'body',
			$this->request->getParams()
		);

		$html = $this->app->renderView(
			get_class( $this ),
			'main',
			[
				'content' => $moduleBody,
				'footerMessages' => $this->getFooterMessages()

			]
		);

		return $html;
	}

	protected function getFooterMessages() {
		return [
			wfMessage( 'emailext-recipient-notice', $this->targetUser->getEmail() )->parse(),
			wfMessage( 'emailext-update-frequency' )->parse(),
			wfMessage( 'emailext-unsubscribe', $this->getUnsubscribeLink() )->parse(),
		];
	}

	/**
	 * TODO Move this into unsubscribe extension?
	 * @return string
	 */
	private function getUnsubscribeLink() {
		$params = [
			'email' => $this->targetUser->getEmail(),
			'timestamp' => time()
		];
		$params['token'] = wfGenerateUnsubToken( $params['email'], $params['timestamp'] );
		$unsubscribeTitle = \GlobalTitle::newFromText( 'Unsubscribe', NS_SPECIAL, \Wikia::COMMUNITY_WIKI_ID );
		return $unsubscribeTitle->getFullURL( $params );
	}

	protected function findUserFromRequest( $paramName, \User $default = null ) {
		$userName = $this->getRequest()->getVal( $paramName );
		if ( empty( $userName ) ) {
			return $default;
		}

		return $this->getUserFromName( $userName );
	}

	/**
	 * Return a user object from a username
	 *
	 * @param string $username
	 *
	 * @return \User
	 * @throws \Email\Fatal
	 */
	protected function getUserFromName( $username ) {
		if ( !$username ) {
			throw new Fatal( wfMessage( 'emailext-error-noname' )->escaped() );
		}

		$user = \User::newFromName( $username );
		$this->assertValidUser( $user );

		return $user;
	}

	/**
	 * A basic check to see if we should send this email or not
	 *
	 * @throws \Email\Check
	 */
	public function assertCanEmail() {
		$this->assertUserHasEmail();
		$this->assertUserWantsEmail();
		$this->assertUserNotBlocked();
	}

	public function assertGoodStatus( \Status $status ) {
		if ( !$status->isGood() ) {
			$msg = wfMessage( "email-error-bad-status", $status->getMessage() )->escaped();
			throw new Fatal( $msg );
		}
	}

	/**
	 * @param $user
	 *
	 * @throws \Email\Fatal
	 */
	public function assertValidUser( $user ) {
		if ( !$user instanceof \User ) {
			throw new Fatal( wfMessage( 'emailext-error-not-user' )->escaped() );
		}

		if ( $user->getId() == 0 ) {
			throw new Fatal( wfMessage( 'emailext-error-empty-user' )->escaped() );
		}
	}

	/**
	 * @throws \Email\Fatal
	 */
	public function assertUserHasEmail() {
		$email = $this->targetUser->getEmail();
		if ( empty( $email ) ) {
			throw new Fatal( wfMessage( 'emailext-error-noemail' )->escaped() );
		}
	}

	/**
	 * @throws \Email\Fatal
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
	 * @throws \Email\Check
	 */
	public function assertUserWantsEmail() {
		if ( $this->targetUser->getBoolOption( 'unsubscribed' ) ) {
			throw new Check( wfMessage( 'emailext-error-no-emails' )->escaped() );
		}
	}

	/**
	 * This checks to see if the current user is blocked
	 *
	 * @throws \Email\Check
	 */
	public function assertUserNotBlocked() {
		if ( $this->currentUser->isBlocked() ) {
			throw new Check( wfMessage( 'emailext-error-user-blocked' )->escaped() );
		}
	}
}
