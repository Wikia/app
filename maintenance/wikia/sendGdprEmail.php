<?php

use \Wikia\Logger\WikiaLogger;

/**
 * @author igor@wikia-inc.com
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ERROR | E_WARNING );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class sendGdprEmail extends Maintenance {
	const ARGUMENT_FILE = 'file';
	const ARGUMENT_LANGUAGE = 'language';

	private $filename;
	private $language;

	public function __construct() {
		parent::__construct();
		$this->addOption( self::ARGUMENT_FILE, 'File with user IDs to process', true, true, 'f' );
		$this->addOption( self::ARGUMENT_LANGUAGE, 'Email language', true, true, 'l' );
		$this->mDescription = 'Send the GDPR notification email';
	}

	public function execute() {
		// FIXME just for measurements START
		global $wgProfiler;
		$wgProfiler = new ProfilerSimpleText([
			'visible' => true
		]);

		global $wgMemc;
		$wgMemc = new EmptyBagOStuff();
		// FIXME just for measurements STOP

		$this->filename = $this->getOption( self::ARGUMENT_FILE );
		$this->language = $this->getOption( self::ARGUMENT_LANGUAGE );

		$file = fopen( $this->filename, 'r' );
		if ( !$file ) {
			print "Unable to read file, exiting\n";
			exit(1);
		}

		$recipients = [];

		// TODO batch by 500
		while ( ( $line = fgets( $file ) ) !== false ) {
			$userId = intval( $line );
			$recipient = $this->userToRecipient( $userId );

			if ( $recipient !== null ) {
				array_push( $recipients, $recipient );
			} else {
				$this->log( 'skip', $userId );
			}
		}

		$this->sendEmail( $recipients );
		$this->output( 'Finished' );

		$wgProfiler->logData();
	}

	private function sendEmail( $recipients ) {
		try {
			$status = UserMailer::send(
				$recipients,
				$this->getSender(),
				$this->getSubject(),
				$this->getBody(),
				null,
				null,
				'gdpr'
			);
		} catch ( Exception $exception ) {
			WikiaLogger::instance()->error( 'sendGdprEmail exception', [
				'exception' => $exception->getMessage(),
			] );

			return;
		}

		if ( !$status->isOK() ) {
			WikiaLogger::instance()->error( 'sendGdprEmail failed', [
				'errors' => $status->getErrorsArray()
			] );

			$this->output( "NOT OK: " . $status->getMessage() );
		}
	}

	private function userToRecipient( int $userId ): MailAddress {
		$user = User::newFromId( $userId );

		if ( !$user->canReceiveEmail() || $user->getGlobalPreference( 'unsubscribed' ) ) {
			return null;
		}

		return new MailAddress( $user );
	}

	private function getSender() {
		global $wgPasswordSender, $wgPasswordSenderName;
		return new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
	}

	private function getSubject() {
		return 'GDPR email';
	}

	private function getBody() {
		return [
			'text' => 'Hi {{name}}.',
			'html' => '<p>Hi {{name}}.</p>'
		];
	}

	private function log( $type, $userId ) {
		// TODO log to file per type
	}
}

$maintClass = sendGdprEmail::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
