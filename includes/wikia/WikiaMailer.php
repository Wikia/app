<?php

/**
 * @package MediaWiki
 * @author Piotr Molski (MoLi) <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
$wgHooks['AlternateUserMailer'][] = "WikiaMailer::sendEmail";

use Wikia\Logger\WikiaLogger;

class WikiaMailer extends UserMailer {

	static $drivers = array(
		'wgEnablePostfixEmail' => 'smtp'
	);

	static private function getDriver() {
		wfProfileIn( __METHOD__ );

		foreach ( self::$drivers as $var => $driver ) {
			if ( array_key_exists($var, $GLOBALS) && !empty( $GLOBALS[$var] ) ) {
				wfProfileOut( __METHOD__ );
				return $driver;
			}
		}

		wfDebug( "WikiaMailer driver not found\n" );
		wfProfileOut( __METHOD__ );
		return false;
	}

	static public function sendEmail( $headers, $to, $from, $subject, $body, $priority = 0, $attachments = null, $sourceType = 'mediawiki' ) {
        wfProfileIn( __METHOD__ );

		$driver = self::getDriver();

		if ( empty( $driver ) ) {
			# Warning: return true to load UserMailer::send function
			wfProfileOut( __METHOD__ );
			return true;
		}

		WikiaSendgridMailer::$factory = $driver;

		wfProfileOut( __METHOD__ );
		return WikiaSendgridMailer::send( $headers, $to, $from, $subject, $body, $priority, $attachments, $sourceType );
	}
}

class WikiaSendgridMailer {

    // Default mail backend
	static public $factory = "smtp";

	static public function send ( $headers, $to, $from, $subject, $body, $priority = 0, $attachments = null, $sourceType = 'mediawiki' ) {
		global $wgEnotifMaxRecips, $wgSMTP;

		wfProfileIn( __METHOD__ );
		require_once( 'Mail2.php' );
		require_once( 'Mail2/mime.php' );

		$logContext = array_merge( $headers, [
			'issue' => 'SOC-910',
			'method' => __METHOD__,
			'to' => $to,
			'subject' => $subject,
			'sourceType' => $sourceType,
		] );
		if ( $sourceType == 'mediawiki' ) {
			// Note, previously called this 'backtrace' but that seemed to mess up logging
			$logContext['btrace'] = self::backtrace();
		}

		WikiaLogger::instance()->info( 'Queuing email for SendGrid', $logContext );

		wfSuppressWarnings();
		$headers['Subject'] = UserMailer::quotedPrintable( $subject );
		// Add a header for the server-name (helps us route where SendGrid will send bounces).
		if ( !empty($_SERVER) && isset( $_SERVER['SERVER_NAME'] ) ) {
			$headers["X-ServerName"] = $_SERVER['SERVER_NAME'];
		}

		try {
			/** @var Mail2 $mail_object */
			$mail_object =& Mail2::factory(WikiaSendgridMailer::$factory, $wgSMTP);
		} catch (Exception $e) {

			$logContext['exception'] = $e;
			WikiaLogger::instance()->error( 'Failed to create mail object', $logContext );

			wfDebug( "PEAR::Mail factory failed: " . $e->getMessage() . "\n" );
			wfRestoreWarnings();
			wfProfileOut( __METHOD__ );
			return $e->getMessage();
		}

		$email_body_txt = $email_body_html = "";
		if ( is_array( $body ) ) {
			if ( isset( $body['text'] ) ) {
				$email_body_txt = $body['text'];
			}
			if ( isset ( $body['html'] ) ) {
				$email_body_html = $body['html'];
			}
		} else {
			$email_body_txt = $body;
		}

		$mime = new Mail_mime();
		$mime->setTXTBody( $email_body_txt );

		$params = array(
			'head_charset' => 'UTF-8',
			'html_charset' => 'UTF-8',
			'text_charset' => 'UTF-8',
			'text_encoding' => 'quoted-printable',
			'html_encoding' => 'quoted-printable'
		);

		# send email with attachements
		if ( !empty( $attachments ) ) {
			if ( !is_array( $attachments ) ) {
				$attachments = array( $attachments );
			}

			foreach ( $attachments as $file ) {
				if ( !is_array( $file ) ) {
					$magic = MimeMagic::singleton();
					$mimeType = $magic->guessMimeType( $file );
					$ext_file = end( explode( '.', $file) );
					$file = array(
						'file'	=> $file,
						'ext'	=> $ext_file,
						'mime'	=> $mimeType
					);
				}

				$filename = $file['file'];
				$ext_filename = $file['ext'];
				if ( !file_exists( $filename ) ) {
					continue;
				}
				$name = $filename; #basename( $filename );
				if ( $ext_filename ) {
					$name = $filename . "." . $ext_filename;
				}
				$mime->addAttachment( $filename, $file['mime'], $name );
			}
		}

		# Old version (1.16 MW with Wikia changes) of sendHTML method
		if ( $email_body_html ) {
			$mime->setHTMLBody( $email_body_html );
			//do not ever try to call these lines in reverse order
		}

		$body = $mime->get( $params );

		$headers['X-SMTPAPI'] = self::createSmtpApiHeader( $headers );

		$headers = $mime->headers( $headers );
		wfDebug( "Sending mail via WikiaSendgridMailer::send\n" );

		$chunks = array_chunk( (array)$to, $wgEnotifMaxRecips );
		foreach ($chunks as $chunk) {
			$headers['To'] = $chunk;
			$status = self::sendWithPear( $mail_object, $chunk, $headers, $body );
			if ( !$status->isOK() ) {
				$logContext['exception'] = $e;
				WikiaLogger::instance()->error( 'Failed to create mail object', $logContext );
				wfRestoreWarnings();
				wfProfileOut( __METHOD__ );
				return $status->getMessage();
			}
		}

		wfProfileOut( __METHOD__ );
		# return false to return Status::newGood() in UserMailer::send method
		return false;
	}

	static public function backtrace( $depth = 8 ) {
		$trace = debug_backtrace();

		// Get rid the same 6 calls that always precede this
		$removeCallsUpTo = 6;

		// If for some reason we weren't called the way we expect, only cut off the call
		// to this function and increase the amount of context we show
		if ( !empty( $trace[5]['function'] ) && $trace[5]['function'] != 'wfRunHooks' ) {
			$removeCallsUpTo = 1;
			$depth += 10;
		}
		$trace = array_slice( $trace, $removeCallsUpTo );

		$formattedTrace = [];
		$count = $depth;
		foreach ( $trace as $frame ) {
			if ( $count == 0 ) {
				break;
			}
			$count--;

			$file = empty( $frame['file'] ) ? '(no file)' : $frame['file'];
			$line = empty( $frame['line'] ) ? '(no line)' : $frame['line'];
			$func = empty( $frame['function'] ) ? '(anonymous)' : $frame['function'];
			$formattedTrace[] = "$file @ $line : $func";
		}

		return $formattedTrace;
	}

	static public function sendWithPear( Mail2 $mailer, $dest, $headers, $body ) {
		try {
			$mailer->send( $dest, $headers, $body );
		} catch (Exception $e) {
			WikiaLogger::instance()->error( 'Mail2::send failed', [
				'exception' => $e,
			] );
			return Status::newFatal( 'pear-mail-error', $e->getMessage());
		}
		return Status::newGood();
	}

	static public function createSmtpApiHeader( $headers ) {
		if ( empty( $headers['X-Msg-Category'] ) ) {
			$category = 'Unknown';
		} else {
			$category = $headers['X-Msg-Category'];
		}

		$wikiaId = F::app()->wg->CityId;
		$dbName = WikiFactory::IDtoDB( F::app()->wg->CityId );

		$content = [
			'category' => $category,
			'unique_args' => [
				'wikia-db' => $dbName,
				'wikia-email-city-id' => $wikiaId,
			],
		];

		return json_encode( $content );
	}
}
