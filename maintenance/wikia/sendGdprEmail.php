<?php

use \Wikia\Logger\WikiaLogger;

/**
 * @author igor@wikia-inc.com
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class sendGdprEmail extends Maintenance {
	const ARGUMENT_FILE = 'file';
	const ARGUMENT_LANGUAGE = 'language';
	const ARGUMENT_LOGS_DIRECTORY = 'logs';
	const GDPR_BATCH_SIZE = 1000;

	const SUBJECTS = [
		'en' => 'We\'re updating our Terms of Use and Privacy Policy',
		'zh' => '我们正在更新我们的使用条款和隐私政策',
		'zh-tw' => '我們正在更新我們的使用條款和隱私權方針',
		'fr' => 'Mise à jour de nos Conditions d\'utilisation et de notre Politique de confidentialité',
		'de' => 'Wir aktualisieren unsere Nutzungsbedingungen und Datenschutzrichtlinien',
		'it' => 'Stiamo aggiornando i nostri termini di utilizzo e la nostra informativa sulla privacy',
		'ja' => '利用規約とプライバシー・ポリシーの更新について',
		'pl' => 'Aktualizujemy nasze Zasady Użytkowania i Politykę Prywatności',
		'pt' => 'Estamos atualizando nossos Termos de uso e Política de privacidade',
		'ru' => 'Мы обновляем наши Условия использования и Политику конфиденциальности',
		'es' => 'Estamos actualizando nuestros Términos de uso y Política de Privacidad'
	];

	private $filename;
	private $language;
	private $logsDirectory;
	private $streams = [];

	public function __construct() {
		parent::__construct();
		$this->addOption( self::ARGUMENT_FILE, 'File with user IDs to process', true, true, 'f' );
		$this->addOption( self::ARGUMENT_LANGUAGE, 'Email language', true, true, 'l' );
		$this->addOption( self::ARGUMENT_LOGS_DIRECTORY, 'Logs directory, no trailing slash', false, true );
		$this->mDescription = 'Send the GDPR notification email';
	}

	public function execute() {
		$this->filename = $this->getOption( self::ARGUMENT_FILE );
		$this->language = $this->getOption( self::ARGUMENT_LANGUAGE );
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

			if ( $perBatchCounter >= self::GDPR_BATCH_SIZE ) {
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
				$this->getSubject(),
				$this->getBody(),
				null,
				null,
				'gdpr'
			);
		} catch ( Exception $exception ) {
			WikiaLogger::instance()->error( 'sendGdprEmail exception', [
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
			WikiaLogger::instance()->error( 'sendGdprEmail failed', [
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
		return self::SUBJECTS[ $this->language ];
	}

	private function getBody() {
		$html = F::app()->renderView( 'Email\Controller\GdprNotificationController', 'getBody', [
			'targetLang' => $this->language
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

$maintClass = sendGdprEmail::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
