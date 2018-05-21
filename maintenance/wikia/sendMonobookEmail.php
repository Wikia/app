<?php

use \Wikia\Logger\WikiaLogger;

/**
 * @author igor@wikia-inc.com
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class sendMonobookEmail extends Maintenance {
	const ARGUMENT_FILE = 'file';
	const ARGUMENT_LOGS_DIRECTORY = 'logs';
	const MONOBOOK_BATCH_SIZE = 1000;

	private $filename;
	private $logsDirectory;
	private $streams = [];

	public function __construct() {
		parent::__construct();
		$this->addOption( self::ARGUMENT_FILE, 'File with user IDs to process', true, true, 'f' );
		$this->addOption( self::ARGUMENT_LOGS_DIRECTORY, 'Logs directory, no trailing slash', false, true );
		$this->mDescription = 'Send the Monobook notification email';
	}

	public function execute() {
		$this->filename = $this->getOption( self::ARGUMENT_FILE );
		$this->logsDirectory = $this->getOption( self::ARGUMENT_LOGS_DIRECTORY, __DIR__ );

		$file = fopen( $this->filename, 'r' );
		if ( !$file ) {
			print "Unable to read file, exiting\n";
			exit(1);
		}

		$batchCounter = 0;
		$perBatchCounter = 0;
		$recipients = [];
		$userIdsForLog = [];

		while ( ( $line = fgets( $file ) ) !== false ) {
			$userId = intval( $line );
			$recipient = $this->userToRecipient( $userId );

			if ( $recipient !== null ) {
				array_push( $recipients, $recipient );
				array_push( $userIdsForLog, $userId );
			} else {
				$this->log( 'skip', [$userId] );
			}

			$perBatchCounter++;

			if ( $perBatchCounter >= self::MONOBOOK_BATCH_SIZE ) {
				list(
					$batchCounter,
					$perBatchCounter,
					$recipients,
					$userIdsForLog
				) = $this->flushBatch( $recipients, $userIdsForLog, $batchCounter );
			}
		}

		// Not a full batch
		$this->flushBatch( $recipients, $userIdsForLog, $batchCounter );
		$this->closeLogFiles();

		echo "Finished\n";
	}

	private function flushBatch( $recipients, $userIdsForLog, $batchCounter ): array
	{
		$this->log( 'batchstart', [ $batchCounter ] );

		if ( !empty( $recipients ) ) {
			$this->sendEmail( $recipients, $userIdsForLog, $batchCounter );
			$this->log( 'success', $userIdsForLog );
		}

		$this->log( 'batchdone', [ $batchCounter ] );
		$batchCounter++;
		$perBatchCounter = 0;
		$recipients = [];
		$userIdsForLog = [];
		return array( $batchCounter, $perBatchCounter, $recipients, $userIdsForLog );
	}

	private function sendEmail( $recipients, $userIdsForLog, $batchCounter ) {
		try {
			$status = UserMailer::send(
				$recipients,
				$this->getSender(),
				'The Future of Monobook on FANDOM',
				$this->getBody(),
				$this->getSender(),
				null,
				'monobook'
			);
		} catch ( Exception $exception ) {
			WikiaLogger::instance()->error( 'sendMonobookEmail exception', [
				'message' => $exception->getMessage(),
				'trace' => $exception->getTraceAsString()
			] );

			echo $exception->getMessage();
			echo "\n";
			echo $exception->getTraceAsString();
			echo "\n";
			echo "Exception for batch " . $batchCounter;
			echo "\n";

			$this->log( 'error', $userIdsForLog );

			return;
		}

		if ( !$status->isOK() ) {
			WikiaLogger::instance()->error( 'sendMonobookEmail failed', [
				'errors' => $status->getErrorsArray()
			] );

			echo "Status not ok for batch " . $batchCounter;
			echo "\n";
			echo  $status->getMessage();
			echo "\n";

			$this->log( 'error', $userIdsForLog );
		}
	}

	private function userToRecipient( int $userId ) {
		$user = User::newFromId( $userId );

		if ( !$user->isEmailConfirmed() ) {
			return null;
		}

		return new MailAddress( $user );
	}

	private function getSender() {
		global $wgPasswordSender, $wgPasswordSenderName;
		return new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
	}

	private function getBody() {
		$html = F::app()->renderView( 'Email\Controller\MonobookNotificationController', 'getBody', [
			'targetLang' => 'en'
		] );

		return [
			'text' => $this->bodyHtmlToText( $html ),
			'html' => $html
		];
	}

	private function log( $type, $items ) {
		if ( empty( $this->streams[ $type ] ) ) {
			$this->streams[ $type ] = fopen( $this->logsDirectory . '/log_' . $type, 'a' );

			if ( $this->streams[ $type ] === false ) {
				throw new Exception( "Can't open log file" );
			}
		}

		foreach ( $items as $item ) {
			$result = fwrite( $this->streams[ $type ], $item . "\n" );

			if ( $result === false || $result === 0 ) {
				throw new Exception( "Can't write log file type: " . $type . ", item: " . $item );
			}
		}
	}

	private function closeLogFiles() {
		foreach ( $this->streams as $stream ) {
			fclose( $stream );
		}
	}

	// Copy paste from EmailController.class.php
	private function bodyHtmlToText( $html ) {
		$bodyText = strip_tags( $html );

		// Get rid of multiple blank white lines
		$bodyText = preg_replace( '/^\h*\v+/m', '', $bodyText );

		// Get rid of leading spacing/indenting
		$bodyText = preg_replace( '/^[\t ]+/m', '', $bodyText );
		return $bodyText;
	}
}

$maintClass = sendMonobookEmail::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
