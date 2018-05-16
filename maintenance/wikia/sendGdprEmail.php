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

	public function __construct() {
		parent::__construct();
		$this->addOption( self::ARGUMENT_FILE, 'File with user IDs to process', true, true, 'f' );
		$this->mDescription = "Send the GDPR notification email";
	}

	public function execute() {
		// FIXME just for measurements START
		global $wgProfiler;
		$wgProfiler = new ProfilerSimpleText([
			"visible" => true
		]);

		global $wgMemc;
		$wgMemc = new EmptyBagOStuff();
		// FIXME just for measurements STOP

		$filename = $this->getOption( self::ARGUMENT_FILE );
		$file = fopen( $filename, 'r' );
		if ( !$file ) {
			print "Unable to read file, exiting\n";
			exit(1);
		}

		while ( ( $line = fgets( $file ) ) !== false ) {
			$userId = intval( $line );
			try {
				$this->sendEmail( $userId );
			} catch ( Exception $exception ) {
				// TODO save to a file
				$this->log( "fail", $userId );
				WikiaLogger::instance()->error( "sendGdprEmail failed", [
					'id' => $userId,
					'exception' => $exception->getMessage(),
				] );
			}
		}

		$this->output( "Finished" );

		$wgProfiler->logData();
	}

	private function sendEmail( $userId ) {
		$user = User::newFromId( $userId );

		if ( !$user->canReceiveEmail() || $user->getGlobalPreference( 'unsubscribed' ) ) {
			$this->log( "skip", $userId );
			return;
		}

		$userLanguage = explode( '-', $user->getGlobalPreference( 'language' ) )[0];

		$status = $user->sendMail(
			$this->getSubject( $userLanguage ),
			$this->getBody( $userLanguage ),
			null,
			null,
			"gdpr",
			$this->getBodyHtml( $userLanguage )
		);

		if ( $status->isOK() ) {
			$this->log( "success", $userId );
		} else {
			$this->log( "fail", $userId );
			WikiaLogger::instance()->error( "sendGdprEmail failed", [
				'id' => $userId,
				'errors' => $status->getErrorsArray()
			] );
		}
	}

	private function getSubject( $userLanguage ) {
		return "GDPR email";
	}

	private function getBody( $userLanguage ) {
		return "Lorem ipsum.";
	}

	private function getBodyHtml( $userLanguage ) {
		return "<p>Lorem ipsum.</p>";
	}

	private function log( $type, $userId ) {
		// TODO log to file per type
	}
}

$maintClass = sendGdprEmail::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
