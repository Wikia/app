<?php

/**
 * Extension to provide customisable email notification of new user creation
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

require_once( 'UserMailer.php' );

class NewUserNotifier {

	private $sender;
	private $user;

	/**
	 * Constructor
	 */
	public function NewUserNotifier() {
		global $wgNewUserNotifSender;
		$this->sender = $wgNewUserNotifSender;
	}

	/**
	 * Send all email notifications
	 *
	 * @param User $user User that was created
	 */
	public function execute( $user ) {
		$this->user = $user;
		wfLoadExtensionMessages( 'NewUserNotifier' );
		$this->sendExternalMails();
		$this->sendInternalMails();
	}

	/**
	 * Send email to external addresses
	 */
	private function sendExternalMails() {
		global $wgNewUserNotifEmailTargets, $wgSitename;
		foreach( $wgNewUserNotifEmailTargets as $target ) {
			userMailer(
				new MailAddress( $target ),
				new MailAddress( $this->sender ),
				wfMsgForContent( 'newusernotifsubj', $wgSitename ),
				$this->makeMessage( $target, $this->user )
			);
		}
	}

	/**
	 * Send email to users
	 */
	private function sendInternalMails() {
		global $wgNewUserNotifTargets, $wgSitename;
		foreach( $wgNewUserNotifTargets as $userSpec ) {
			$user = $this->makeUser( $userSpec );
			if( $user instanceof User && $user->isEmailConfirmed() ) {
				$user->sendMail(
					wfMsgForContent( 'newusernotifsubj', $wgSitename ),
					$this->makeMessage( $user->getName(), $this->user ),
					$this->sender
				);
			}
		}
	}

	/**
	 * Initialise a user from an identifier or a username
	 *
	 * @param mixed $spec User identifier or name
	 * @return User
	 */
	private function makeUser( $spec ) {
		$name = is_integer( $spec ) ? User::whoIs( $spec ) : $spec;
		$user = User::newFromName( $name );
		if( $user instanceof User && $user->getId() > 0 )
			return $user;
		return null;
	}

	/**
	 * Build a notification email
	 *
	 * @param string $recipient Name of the recipient
	 * @param User $user User that was created
	 */
	private function makeMessage( $recipient, $user ) {
		global $wgSitename, $wgContLang;
		return wfMsgForContent(
			'newusernotifbody',
			$recipient,
			$user->getName(),
			$wgSitename,
			$wgContLang->timeAndDate( wfTimestampNow() )
		);
	}

	/**
	 * Hook account creation
	 *
	 * @param User $user User that was created
	 * @return bool
	 */
	public static function hook( $user ) {
		$notifier = new self();
		$notifier->execute( $user );
		return true;
	}
}
