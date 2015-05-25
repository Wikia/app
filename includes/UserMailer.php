<?php
/**
 * Classes used to send e-mails
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @author <brion@pobox.com>
 * @author <mail@tgries.de>
 * @author Tim Starling
 */


/**
 * Stores a single person's name and email address.
 * These are passed in via the constructor, and will be returned in SMTP
 * header format when requested.
 */
class MailAddress {
	/**
	 * @param $address string|User string with an email address, or a User object
	 * @param $name String: human-readable name if a string address is given
	 * @param $realName String: human-readable real name if a string address is given
	 */
	function __construct( $address, $name = null, $realName = null ) {
		if ( is_object( $address ) && $address instanceof User ) {
			$this->address = $address->getEmail();
			$this->name = $address->getName();
			$this->realName = $address->getRealName();
		} else if ( is_object( $address ) && $address instanceof MailAddress ) {
			$this->address = strval( $address->address );
			$this->name = $name ? $name : strval( $address->name );
			$this->realName = $realName ? $realName : strval( $address->realName );
		} else {
			$this->address = strval( $address );
			$this->name = strval( $name );
			$this->realName = strval( $realName );
		}
	}

	/**
	 * Return formatted and quoted address to insert into SMTP headers
	 * @return string
	 */
	function toString() {
		# PHP's mail() implementation under Windows is somewhat shite, and
		# can't handle "Joe Bloggs <joe@bloggs.com>" format email addresses,
		# so don't bother generating them
		if ( $this->address ) {
			if ( $this->name != '' && !wfIsWindows() ) {
				$name = ( F::app()->wg->EnotifUseRealName && $this->realName ) ? $this->realName : $this->name;
				$quoted = UserMailer::quotedPrintable( $name );
				if ( strpos( $quoted, '.' ) !== false || strpos( $quoted, ',' ) !== false ) {
					$quoted = '"' . $quoted . '"';
				}
				return "$quoted <{$this->address}>";
			} else {
				return $this->address;
			}
		} else {
			return "";
		}
	}

	function __toString() {
		return $this->toString();
	}
}


/**
 * Collection of static functions for sending mail
 */
class UserMailer {
	static $mErrorString;

	/**
	 * Send mail using a PEAR mailer
	 *
	 * @param $mailer
	 * @param $dest
	 * @param $headers
	 * @param $body
	 *
	 * @return Status
	 */
	protected static function sendWithPear( $mailer, $dest, $headers, $body ) {
		$mailResult = $mailer->send( $dest, $headers, $body );

		# Based on the result return an error string,
		if ( PEAR::isError( $mailResult ) ) {
			wfDebug( "PEAR::Mail failed: " . $mailResult->getMessage() . "\n" );
			return Status::newFatal( 'pear-mail-error', $mailResult->getMessage() );
		} else {
			return Status::newGood();
		}
	}

	/**
	 * Creates a single string from an associative array
	 *
	 * @param $headers Associative Array: keys are header field names,
	 *                 values are ... values.
	 * @param $endl String: The end of line character.  Defaults to "\n"
	 * @return String
	 */
	static function arrayToHeaderString( $headers, $endl = "\n" ) {
		foreach ( $headers as $name => $value ) {
			$string[] = "$name: $value";
		}
		return implode( $endl, $string );
	}

	/**
	 * Create a value suitable for the MessageId Header
	 *
	 * @return String
	 */
	static function makeMsgId() {
		$msgid = uniqid( wfWikiID() . ".", true ); /* true required for cygwin */
		if ( is_array( F::app()->wg->SMTP ) && isset( $wgSMTP['IDHost'] ) && $wgSMTP['IDHost'] ) {
			$domain = $wgSMTP['IDHost'];
		} else {
			$url = wfParseUrl( F::app()->wg->Server );
			$domain = $url['host'];
		}
		return "<$msgid@$domain>";
	}

	/**
	 * This function will perform a direct (authenticated) login to
	 * a SMTP Server to use for mail relaying if 'wgSMTP' specifies an
	 * array of parameters. It requires PEAR:Mail to do that.
	 * Otherwise it just uses the standard PHP 'mail' function.
	 *
	 * @param MailAddress $to : recipient's email (or an array of them)
	 * @param MailAddress $from : sender's email
	 * @param String $subject : email's subject.
	 * @param String $body : email's text.
	 * $body can be array with text and html version of email message, and also can contain attachements
	 * $body = array('text' => 'Email text', 'html' => '<b>Email text</b>')
	 * @param MailAddress $replyTo : optional reply-to email (default: null).
	 * @param String $contentType : optional custom Content-Type
	 * @param String $category : optional category for statistic
	 * @param int $priority : optional priority for email
	 * @param Array $attachments : optional list of files to send as attachments
	 *
	 * @return Status object
	 * @throws MWException
	 */
	public static function send(
		MailAddress $to,
		MailAddress $from,
		$subject,
		$body,
		MailAddress $replyTo = null,
		$contentType = null,
		$category = 'UserMailer',
		$priority = 0,
		$attachments = []
	) {

		if ( !is_array( $to ) ) {
			$to = [ $to ];
		}

		# Make sure we have at least one address
		$has_address = false;
		foreach ( $to as $u ) {
			if ( $u->address ) {
				$has_address = true;
				break;
			}
		}
		if ( !$has_address ) {
			return Status::newFatal( 'user-mail-no-addy' );
		}
		wfRunHooks( 'UserMailerSend', [ &$to ] );

		# Forge email headers
		# -------------------
		#
		# WARNING
		#
		# DO NOT add To: or Subject: headers at this step. They need to be
		# handled differently depending upon the mailer we are going to use.
		#
		# To:
		#  PHP mail() first argument is the mail receiver. The argument is
		#  used as a recipient destination and as a To header.
		#
		#  PEAR mailer has a recipient argument which is only used to
		#  send the mail. If no To header is given, PEAR will set it to
		#  to 'undisclosed-recipients:'.
		#
		#  NOTE: To: is for presentation, the actual recipient is specified
		#  by the mailer using the Rcpt-To: header.
		#
		# Subject:
		#  PHP mail() second argument to pass the subject, passing a Subject
		#  as an additional header will result in a duplicate header.
		#
		#  PEAR mailer should be passed a Subject header.
		#
		# -- hashar 20120218

		$headers['From'] = $from->toString();
		$headers['Return-Path'] = $from->address;

		if ( $replyTo && $replyTo instanceof MailAddress ) {
			$headers['Reply-To'] = $replyTo->toString();
		}

		$headers['Date'] = date( 'r' );
		$headers['MIME-Version'] = '1.0';

		if ( empty( $attachments ) ) {
			$headers['Content-Type'] = ( is_null( $contentType ) ?
				'text/plain; charset=UTF-8' : $contentType );
			$headers['Content-Transfer-Encoding'] = '8bit';
		}

		$headers['Message-ID'] = self::makeMsgId();
		$headers['X-Mailer'] = 'MediaWiki mailer';

		$headers['X-Msg-Category'] = $category;
		if ( $priority ) {
			$headers['X-Priority'] = $priority;
		}

		$ret = wfRunHooks( 'AlternateUserMailer', [ $headers, $to, $from, $subject, $body , $priority, $attachments ] );
		if ( $ret === false ) {
			return Status::newGood();
		} elseif ( $ret !== true ) {
			return Status::newFatal( 'php-mail-error', $ret );
		}

		# MoLi: body can be an array with text and html message
		# MW core uses only text version of email message, so $body as array should be used only with AlternateUserMailer hook
		if ( is_array( $body ) && isset( $body['text'] ) ) {
			$body = $body['text'];
		}

		if ( is_array( F::app()->wg->SMTP ) ) {
			#
			# PEAR MAILER
			#

			if ( function_exists( 'stream_resolve_include_path' ) ) {
				$found = stream_resolve_include_path( 'Mail.php' );
			} else {
				$found = Fallback::stream_resolve_include_path( 'Mail.php' );
			}
			if ( !$found ) {
				throw new MWException( 'PEAR mail package is not installed' );
			}
			require_once( 'Mail.php' );

			wfSuppressWarnings();

			// Create the mail object using the Mail::factory method
			$mail_object =& Mail::factory( 'smtp', F::app()->wg->SMTP );
			if ( PEAR::isError( $mail_object ) ) {
				wfDebug( "PEAR::Mail factory failed: " . $mail_object->getMessage() . "\n" );
				wfRestoreWarnings();
				return Status::newFatal( 'pear-mail-error', $mail_object->getMessage() );
			}

			wfDebug( "Sending mail via PEAR::Mail\n" );

			$headers['Subject'] = self::quotedPrintable( $subject );

			# When sending only to one recipient, shows it its email using To:
			if ( count( $to ) == 1 ) {
				$headers['To'] = $to[0]->toString();
			}

			# Split jobs since SMTP servers tends to limit the maximum
			# number of possible recipients.
			$chunks = array_chunk( $to, F::app()->wg->EnotifMaxRecips );
			foreach ( $chunks as $chunk ) {
				if ( !wfRunHooks( 'ComposeMail', [ $chunk, &$body, &$headers ] ) ) {
					continue;
				}
				$status = self::sendWithPear( $mail_object, $chunk, $headers, $body );
				# FIXME : some chunks might be sent while others are not!
				if ( !$status->isOK() ) {
					wfRestoreWarnings();
					return $status;
				}
			}
			wfRestoreWarnings();
			return Status::newGood();
		} else	{
			#
			# PHP mail()
			#

			# Line endings need to be different on Unix and Windows due to
			# the bug described at http://trac.wordpress.org/ticket/2603
			if ( wfIsWindows() ) {
				$body = str_replace( "\n", "\r\n", $body );
				$endl = "\r\n";
			} else {
				$endl = "\n";
			}

			if ( count( $to ) > 1 ) {
				$headers['To'] = 'undisclosed-recipients:;';
			}
			$headers = self::arrayToHeaderString( $headers, $endl );

			wfDebug( "Sending mail via internal mail() function\n" );

			self::$mErrorString = '';
			$html_errors = ini_get( 'html_errors' );
			ini_set( 'html_errors', '0' );

			$safeMode = wfIniGetBool( 'safe_mode' );
			foreach ( $to as $recip ) {
				if ( !wfRunHooks( 'ComposeMail', array( $recip, &$body, &$headers ) ) ) {
					continue;
				}
				if ( $safeMode ) {
					$sent = mail( $recip, self::quotedPrintable( $subject ), $body, $headers );
				} else {
					$sent = mail( $recip, self::quotedPrintable( $subject ), $body, $headers, F::app()->wg->AdditionalMailParams );
				}
			}

			ini_set( 'html_errors', $html_errors );

			if ( self::$mErrorString ) {
				wfDebug( "Error sending mail: " . self::$mErrorString . "\n" );
				return Status::newFatal( 'php-mail-error', self::$mErrorString );
			} elseif ( ! $sent ) {
				// mail function only tells if there's an error
				wfDebug( "Unknown error sending mail\n" );
				return Status::newFatal( 'php-mail-error-unknown' );
			} else {
				return Status::newGood();
			}
		}
	}

	/**
	 * Converts a string into a valid RFC 822 "phrase", such as is used for the sender name
	 * @param $phrase string
	 * @return string
	 */
	public static function rfc822Phrase( $phrase ) {
		$phrase = strtr( $phrase, [ "\r" => '', "\n" => '', '"' => '' ] );
		return '"' . $phrase . '"';
	}

	/**
	 * Converts a string into quoted-printable format
	 * @since 1.17
	 */
	public static function quotedPrintable( $string, $charset = '' ) {
		# Probably incomplete; see RFC 2045
		if ( empty( $charset ) ) {
			$charset = 'UTF-8';
		}
		$charset = strtoupper( $charset );
		$charset = str_replace( 'ISO-8859', 'ISO8859', $charset ); // ?

		$illegal = '\x00-\x08\x0b\x0c\x0e-\x1f\x7f-\xff=';
		$replace = $illegal . '\t ?_';
		if ( !preg_match( "/[$illegal]/", $string ) ) {
			return $string;
		}
		$out = "=?$charset?Q?";
		$out .= preg_replace_callback( "/([$replace])/",
			[ __CLASS__, 'quotedPrintableCallback' ], $string );
		$out .= '?=';
		return $out;
	}

	protected static function quotedPrintableCallback( $matches ) {
		return sprintf( "=%02X", ord( $matches[1] ) );
	}
}
