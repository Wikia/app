<?php

/**
 * @package MediaWiki
 * @author Piotr Molski (MoLi) <moli@wikia-inc.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */
$wgHooks['AlternateUserMailer'][] = "WikiaMailer::sendEmail";

class WikiaMailer extends UserMailer {
	
	static $drivers = array(
		'wgForceSendgridEmail' => 'WikiaSendgridMailer'
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
	
	static public function sendEmail( $headers, $to, $from, $subject, $body, $priority = 0, $attachments = null ) {
        wfProfileIn( __METHOD__ );

		/* @var $driver WikiaSendgridMailer */
		$driver = self::getDriver();
		
		if ( empty( $driver ) ) {
			# Warning: return true to load UserMailer::send function
			wfProfileOut( __METHOD__ );
			return true;
		}
		
		wfProfileOut( __METHOD__ );
		return $driver::send( $headers, $to, $from, $subject, $body, $priority, $attachments );
	}
}

class WikiaSendgridMailer {
	
	static public function send ( $headers, $to, $from, $subject, $body, $priority = 0, $attachments = null ) {
		global $wgEnotifMaxRecips;

		wfProfileIn( __METHOD__ );
		require_once( 'Mail.php' );
		require_once( 'Mail/mime.php' );
		
		wfSuppressWarnings();
		$headers['Subject'] = UserMailer::quotedPrintable( $subject );
		// Add a header for the server-name (helps us route where SendGrid will send bounces).
		if ( !empty($_SERVER) && isset( $_SERVER['SERVER_NAME'] ) ) {
			$headers["X-ServerName"] = $_SERVER['SERVER_NAME'];
		}

		$mail_object =& Mail::factory('wikiadb');

		if ( PEAR::isError( $mail_object ) ) {
			wfDebug( "PEAR::Mail factory failed: " . $mail_object->getMessage() . "\n" );
			wfRestoreWarnings();
			wfProfileOut( __METHOD__ );
			return $mail_object->getMessage();
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
			'text_encoding' => '8bit', 
			'html_encoding' => '8bit'
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

		$headers = $mime->headers( $headers );
		wfDebug( "Sending mail via WikiaSendgridMailer::send\n" );

		$chunks = array_chunk( (array)$to, $wgEnotifMaxRecips );
		foreach ($chunks as $chunk) {
			$headers['To'] = $chunk;
			$status = self::sendWithPear( $mail_object, $chunk, $headers, $body );
			if ( !$status->isOK() ) {
				wfRestoreWarnings();
				wfProfileOut( __METHOD__ );
				return $status->getMessage();
			}
		}

		wfProfileOut( __METHOD__ );
		# return false to return Status::newGood() in UserMailer::send method
		return false;
	}

	static public function sendWithPear( $mailer, $dest, $headers, $body ) {
		$mailResult = $mailer->send( $dest, $headers, $body );

		# Based on the result return an error string,
		if ( PEAR::isError( $mailResult ) ) {
			wfDebug( "PEAR::Mail failed: " . $mailResult->getMessage() . "\n" );
			return Status::newFatal( 'pear-mail-error', $mailResult->getMessage() );
		} else {
			return Status::newGood();
		}
	}
}
