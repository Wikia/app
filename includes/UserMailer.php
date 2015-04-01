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
		/* Wikia change begin - @author: wladek */
		/* #57817: Email "from" field description change */
		} else if( is_object( $address ) && $address instanceof MailAddress ) {
			$this->address = strval( $address->address );
			$this->name = $name ? $name : strval( $address->name );
			$this->realName = $realName ? $realName : strval( $address->realName );
		/* Wikia change end */
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
				global $wgEnotifUseRealName;
				$name = ( $wgEnotifUseRealName && $this->realName ) ? $this->realName : $this->name;
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
		foreach( $headers as $name => $value ) {
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
		global $wgSMTP, $wgServer;

		$msgid = uniqid( wfWikiID() . ".", true ); /* true required for cygwin */
		if ( is_array($wgSMTP) && isset($wgSMTP['IDHost']) && $wgSMTP['IDHost'] ) {
			$domain = $wgSMTP['IDHost'];
		} else {
			$url = wfParseUrl($wgServer);
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
	 * @param $to MailAddress: recipient's email (or an array of them)
	 * @param $from MailAddress: sender's email
	 * @param $subject String: email's subject.
	 * @param $body String: email's text. 
	 * (<Wikia>
	 * $body can be array with text and html version of email message, and also can contain attachements
	 * $body = array('text' => 'Email text', 'html' => '<b>Email text</b>')
	 * </Wikia>)
	 * @param $replyto MailAddress: optional reply-to email (default: null).
	 * @param $contentType String: optional custom Content-Type (default: text/plain; charset=UTF-8)
	 * @param $contentType String: optional custom Content-Type
	 * @param $category String: optional category for statistic (added by Wikia)
	 * @param $priority int: optional priority for email (added by Wikia)
	 * @param $attachements Array: optional list of files to send as attachements (added by Wikia)
	 * @return Status object
	 */
	public static function send( $to, $from, $subject, $body, $replyto = null, $contentType = null, $category='UserMailer', $priority = 0,
	$attachements = array() ) {
		global $wgSMTP, $wgEnotifMaxRecips, $wgAdditionalMailParams;

		if ( !is_array( $to ) ) {
			$to = array( $to );
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
		/* Wikia change - begin */
		wfRunHooks( 'UserMailerSend', array( &$to ) );
		/* Wikia change - end */

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

		if ( $replyto && $replyto instanceof MailAddress /* Wikia change (BugId:6519) */ ) {
			$headers['Reply-To'] = $replyto->toString();
		}

		$headers['Date'] = date( 'r' );
		$headers['MIME-Version'] = '1.0';

		/* <Wikia> */
		if(empty($attachements)) {
		/* </Wikia> */
			$headers['Content-Type'] = ( is_null( $contentType ) ?
				'text/plain; charset=UTF-8' : $contentType );
			$headers['Content-Transfer-Encoding'] = '8bit';
		/* <Wikia> */
		}
		/* </Wikia> */

		$headers['Message-ID'] = self::makeMsgId();
		$headers['X-Mailer'] = 'MediaWiki mailer';

		# <Wikia> merged 1.19 (MoLi)
		$headers['X-Msg-Category'] = $category;
		if ( $priority ) {
			$headers['X-Priority'] = $priority;
		}
		# </Wikia>

		$ret = wfRunHooks( 'AlternateUserMailer', array( $headers, $to, $from, $subject, $body
		/*<Wikia>*/
			, $priority, $attachements
		/*</Wikia>*/
		) );
		if ( $ret === false ) {
			return Status::newGood();
		} elseif ( $ret !== true ) {
			return Status::newFatal( 'php-mail-error', $ret );
		}

		# <Wikia> 
		# MoLi: body can be an array with text and html message
		# MW core uses only text version of email message, so $body as array should be used only with AlternateUserMailer hook
		if ( is_array( $body ) && isset( $body['text'] ) ) {
			$body = $body['text'];
		}
		# </Wikia>

		if ( is_array( $wgSMTP ) ) {
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
			$mail_object =& Mail::factory( 'smtp', $wgSMTP );
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
			$chunks = array_chunk( $to, $wgEnotifMaxRecips );
			foreach ( $chunks as $chunk ) {
				# <Wikia>
				if ( !wfRunHooks( 'ComposeMail', array( $chunk, &$body, &$headers ) ) ) {
					continue;
				}
				# </Wikia>
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

			if( count($to) > 1 ) {
				$headers['To'] = 'undisclosed-recipients:;';
			}
			$headers = self::arrayToHeaderString( $headers, $endl );

			wfDebug( "Sending mail via internal mail() function\n" );

			self::$mErrorString = '';
			$html_errors = ini_get( 'html_errors' );
			ini_set( 'html_errors', '0' );

			$safeMode = wfIniGetBool( 'safe_mode' );
			foreach ( $to as $recip ) {
				# <Wikia>
				if ( !wfRunHooks( 'ComposeMail', array( $recip, &$body, &$headers ) ) ) {
					continue;
				}
				# </Wikia>
				if ( $safeMode ) {
					$sent = mail( $recip, self::quotedPrintable( $subject ), $body, $headers );
				} else {
					$sent = mail( $recip, self::quotedPrintable( $subject ), $body, $headers, $wgAdditionalMailParams );
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
		$phrase = strtr( $phrase, array( "\r" => '', "\n" => '', '"' => '' ) );
		return '"' . $phrase . '"';
	}

	/**
	 * Converts a string into quoted-printable format
	 * @since 1.17
	 */
	public static function quotedPrintable( $string, $charset = '' ) {
		# Probably incomplete; see RFC 2045
		if( empty( $charset ) ) {
			$charset = 'UTF-8';
		}
		$charset = strtoupper( $charset );
		$charset = str_replace( 'ISO-8859', 'ISO8859', $charset ); // ?

		$illegal = '\x00-\x08\x0b\x0c\x0e-\x1f\x7f-\xff=';
		$replace = $illegal . '\t ?_';
		if( !preg_match( "/[$illegal]/", $string ) ) {
			return $string;
		}
		$out = "=?$charset?Q?";
		$out .= preg_replace_callback( "/([$replace])/",
			array( __CLASS__, 'quotedPrintableCallback' ), $string );
		$out .= '?=';
		return $out;
	}

	protected static function quotedPrintableCallback( $matches ) {
		return sprintf( "=%02X", ord( $matches[1] ) );
	}
}

/**
 * This module processes the email notifications when the current page is
 * changed. It looks up the table watchlist to find out which users are watching
 * that page.
 *
 * The current implementation sends independent emails to each watching user for
 * the following reason:
 *
 * - Each watching user will be notified about the page edit time expressed in
 * his/her local time (UTC is shown additionally). To achieve this, we need to
 * find the individual timeoffset of each watching user from the preferences..
 *
 * Suggested improvement to slack down the number of sent emails: We could think
 * of sending out bulk mails (bcc:user1,user2...) for all these users having the
 * same timeoffset in their preferences.
 *
 * Visit the documentation pages under http://meta.wikipedia.com/Enotif
 *
 *
 */
class EmailNotification {

	/**
	 * @var User
	 */
	private $editor;

	/**
	 * @var Title
	 */
	private $title;

	private $timestamp;

	private $summary;

	private $minorEdit;

	private $currentRevId;

	private $previousRevId;

	private $action;

	private $otherParam;

	private $subject;

	private $body;

	private $replyto;

	private $from;

	private $bodyHTML;

	private $composedCommon = false;

	/**
	* @param User $editor
	* @param Title $title
	* @param string $timestamp : Edit timestamp
	* @param string $summary : Edit summary
	* @param bool $minorEdit
	* @param int $currentRevId : Revision ID
	* @param int $previousRevId : Revision ID
	* @param string $action (Wikia)
	* @param array $otherParam
	 */
	public function __construct( $editor, $title, $timestamp, $summary, $minorEdit, $currentRevId = 0, $previousRevId = 0, $action = '', $otherParam = [] ) {
		$this->editor = $editor;
		$this->title = $title;
		$this->timestamp = $timestamp;
		$this->summary = $summary;
		$this->minorEdit = $minorEdit;
		$this->currentRevId = $currentRevId;
		$this->previousRevId = $previousRevId;
		$this->action = $action;
		$this->otherParam = $otherParam;
	}

	/**
	 * Send emails corresponding to the user $editor editing the page $title.
	 * Also updates wl_notificationtimestamp.
	 *
	 * May be deferred via the job queue.
	 */
	public function notifyOnPageChange() {
		global $wgEnotifWatchlist, $wgShowUpdatedMarker;

		if ( $this->title->getNamespace() < 0 ) {
			return;
		}

		if( !wfRunHooks( 'AllowNotifyOnPageChange', array( $this->editor, $this->title ) ) ) {
			return;
		}

		// Build a list of users to notify
		$watchers = [];
		if ( $wgEnotifWatchlist || $wgShowUpdatedMarker ) {
			$notificationTimeoutSql = $this->getTimeOutSql();
			$watchers = $this->getWatchersToNotify( $notificationTimeoutSql );
			if ( $watchers ) {
				$this->updateWatchedItem( $watchers );
			}
			wfRunHooks( 'NotifyOnSubPageChange', array ( $watchers, $this->title, $this->editor, $notificationTimeoutSql ) );
		}
		if ( $this->shouldSendEmail( $watchers ) ) {
			$this->actuallyNotifyOnPageChange( $watchers );
		}
	}

	/**
	 * Add a timeout to the watchlist email block
	 */
	private function getTimeOutSql(){
		global $wgEnableWatchlistNotificationTimeout, $wgWatchlistNotificationTimeout;

		if ( !empty( $this->otherParam['notisnull'] ) ) {
			$notificationTimeoutSql = "1";
		} elseif ( !empty( $wgEnableWatchlistNotificationTimeout ) && isset( $WatchlistNotificationTimeout ) ) {
			$blockTimeout = wfTimestamp( TS_MW, wfTimestamp( TS_UNIX, $this->timestamp ) - intval( $wgWatchlistNotificationTimeout ) );
			$notificationTimeoutSql = "wl_notificationtimestamp IS NULL OR wl_notificationtimestamp < '$blockTimeout'";
		} else {
			$notificationTimeoutSql = 'wl_notificationtimestamp IS NULL';
		}

		return $notificationTimeoutSql;
	}

	private function getWatchersToNotify( $notificationTimeoutSql ) {
		$watchers = [];
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select( [ 'watchlist' ],
			[ 'wl_user' ],
			[
				'wl_title' => $this->title->getDBkey(),
				'wl_namespace' => $this->title->getNamespace(),
				'wl_user != ' . intval( $this->editor->getID() ),
				$notificationTimeoutSql
			], __METHOD__
		);

		foreach ( $res as $row ) {
			$watchers[] = $row->wl_user;
		}

		return $watchers;
	}

	/**
	 * Update wl_notificationtimestamp for all watching users except the editor
	 */
	private function updateWatchedItem( $watchers ) {
		$wl = WatchedItem::fromUserTitle( $this->editor, $this->title );
		$wl->updateWatch( $watchers, $this->timestamp );
	}

	/**
	 * Check if there are either 1.) users watching the page, or 2.) the page which was
	 * edited is a User Talk page and the owner of that page wants to receive notifications
	 * when their User Talk page is changed.
	 * @param array $watchers
	 * @return bool
	 */
	private function shouldSendEmail( array $watchers ) {
		global $wgUsersNotifiedOnAllChanges, $wgEnotifMinorEdits, $wgEnotifUserTalk;

		$sendEmail = true;
		// If nobody is watching the page, and there are no users notified on all changes
		// don't bother creating a job/trying to send emails
		// $watchers deals with $wgEnotifWatchlist
		if ( !count( $watchers ) && !count( $wgUsersNotifiedOnAllChanges ) ) {
			$sendEmail = false;
			// Only send notification for non minor edits, unless $wgEnotifMinorEdits
			if ( !$this->minorEdit || ( $wgEnotifMinorEdits && !$this->editor->isAllowed( 'nominornewtalk' ) ) ) {
				if ( $wgEnotifUserTalk && $this->isUserTalkPage() && $this->canSendUserTalkEmail() ) {
					$sendEmail = true;
				}
			}
		}

		return $sendEmail;
	}

	/**
	 * Immediate version of notifyOnPageChange().
	 *
	 * Send emails corresponding to the user $editor editing the page $title.
	 * Also updates wl_notificationtimestamp.
	 *
	 */
	private function actuallyNotifyOnPageChange( $watchers ) {
		global $wgEnotifWatchlist;
		global $wgEnotifMinorEdits, $wgEnotifUserTalk;

		$this->setReplyToAndFromAddresses();

		# The following code is only run, if several conditions are met:
		# 1. EmailNotification for pages (other than user_talk pages) must be enabled
		# 2. minor edits (changes) are only regarded if the global flag indicates so
		$userTalkId = false;
		if ( !$this->minorEdit || ( $wgEnotifMinorEdits && !$this->editor->isAllowed( 'nominornewtalk' ) ) ) {

			if ( $wgEnotifUserTalk && $this->isUserTalkPage() && $this->canSendUserTalkEmail() ) {
				$targetUser = User::newFromName( $this->title->getText() );
				$this->compose( $targetUser );
				$userTalkId = $targetUser->getId();

				// Send mail to user when comment on his user talk has been added
				$fakeUser = null;
				wfRunHooks('UserMailer::NotifyUser', array( $this->title, &$fakeUser ));
				if ( $fakeUser instanceof User && $fakeUser->getOption( 'enotifusertalkpages' ) && $fakeUser->isEmailConfirmed() ) {
					$this->compose( $fakeUser );
				}
			}

			if ( $wgEnotifWatchlist ) {
				// Send updates to watchers other than the current editor
				$userArray = UserArray::newFromIDs( $watchers );

				/* @var $watchingUser User */
				foreach ( $userArray as $watchingUser ) {
					if ( $watchingUser->getOption( 'enotifwatchlistpages' ) &&
						( !$this->minorEdit || $watchingUser->getOption( 'enotifminoredits' ) ) &&
						$watchingUser->isEmailConfirmed() &&
						$watchingUser->getID() != $userTalkId
						&& !$watchingUser->getBoolOption( 'unsubscribed' ) )
					{
						$this->compose( $watchingUser );
					}
				}
			}
		}
		$this->emailUsersNotifiedOnAllChanges();
	}

	private function setReplyToAndFromAddresses() {
		global $wgPasswordSender, $wgPasswordSenderName, $wgNoReplyAddress;
		global $wgEnotifFromEditor, $wgEnotifRevealEditorAddress;

		# Reveal the page editor's address as REPLY-TO address only if
		# the user has not opted-out and the option is enabled at the
		# global configuration level.
		$adminAddress = new MailAddress( $wgPasswordSender, $wgPasswordSenderName );
		if ( $wgEnotifRevealEditorAddress
			&& ( $this->editor->getEmail() != '' )
			&& $this->editor->getOption( 'enotifrevealaddr' ) )
		{
			$editorAddress = new MailAddress( $this->editor );
			if ( $wgEnotifFromEditor ) {
				$this->from    = $editorAddress;
			} else {
				$this->from    = $adminAddress;
				$this->replyto = $editorAddress;
			}
		} else {
			$this->from    = $adminAddress;
			$this->replyto = new MailAddress( $wgNoReplyAddress );
		}
	}

	private function emailUsersNotifiedOnAllChanges() {
		global $wgUsersNotifiedOnAllChanges;

		foreach ( $wgUsersNotifiedOnAllChanges as $name ) {
			// No point notifying the user that actually made the change!
			if ( $this->editor->getName() == $name ) {
				continue;
			}
			$user = User::newFromName( $name );
			$this->compose( $user );
		}
	}

	/**
	 * @return bool
	 */
	private function canSendUserTalkEmail() {
		$targetUser = User::newFromName( $this->title->getText() );
		if ( $targetUser instanceof User && // user exists
			!$targetUser->isAnon() && // and they not anonymous
			$targetUser->getId() != $this->editor->getId() && // and they are not the user who made the edit
			$targetUser->getOption( 'enotifusertalkpages' ) && // and they want to be notified about talk pages changes
			( !$this->minorEdit || $targetUser->getOption( 'enotifminoredits' ) ) && // and this is not a minor edit, or they want to know about minor edits
			$targetUser->isEmailConfirmed() /* and their email is confirmed */ ) {
				return true;
			}

		return false;
	}

	/**
	 * Generate the generic "this page has been changed" e-mail text.
	 */
	private function composeCommonMailtext() {
		global $wgEnotifUseRealName;
		global $wgLanguageCode;

		$this->composedCommon = true;

		# <Wikia>
		$action = strtolower($this->action);
		$subject = wfMessage( 'enotif_subject_' . $action )->inContentLanguage()->text();
		if ( wfEmptyMsg( 'enotif_subject_' . $action, $subject ) ) {
			$subject = wfMessage( 'enotif_subject' )->inContentLanguage()->text();
		}
		list ( $body, $bodyHTML ) = wfMsgHTMLwithLanguageAndAlternative(
			'enotif_body' . ( $action == '' ? '' : ( '_' . $action ) ),
			'enotif_body',
			$wgLanguageCode
		);
		# </Wikia>

		# You as the WikiAdmin and Sysops can make use of plenty of
		# named variables when composing your notification emails while
		# simply editing the Meta pages

		$keys = [];
		$postTransformKeys = [];

		if ( $this->isNewPage() ) {
			// WIKIA change, watchlist link tracking
			list ( $keys['$NEWPAGE'], $keys['$NEWPAGEHTML'] ) = wfMsgHTMLwithLanguageAndAlternative (
				'enotif_lastvisited',
				'enotif_lastvisited',
				$wgLanguageCode,
				array(),
				$this->title->getFullUrl( 's=wldiff&diff=0&previousRevId=' . $this->previousRevId )
			);
			$keys['$OLDID']   = $this->previousRevId;
			$keys['$CHANGEDORCREATED'] = wfMessage( 'changed' )->inContentLanguage()->plain();
		} else {
			# <Wikia>
			if ( $action == '' ) {
				//no previousRevId + empty action = create edit, ok to use newpagetext
				$keys['$NEWPAGEHTML'] = $keys['$NEWPAGE'] = wfMessage( 'enotif_newpagetext' )->inContentLanguage()->plain();
			} else {
				//no previousRevId + action = event, dont show anything, confuses users
				$keys['$NEWPAGEHTML'] = $keys['$NEWPAGE'] = '';
			}
			# </Wikia>
			# clear $OLDID placeholder in the message template
			$keys['$OLDID']   = '';
			$keys['$CHANGEDORCREATED'] = wfMessage( 'created' )->inContentLanguage()->plain();
		}

		$keys['$PAGETITLE'] = $this->title->getPrefixedText();
		$keys['$PAGETITLE_URL'] = $this->title->getCanonicalUrl('s=wl');
		$keys['$PAGEMINOREDIT'] = $this->minorEdit ? wfMessage( 'minoredit' )->inContentLanguage()->plain() : '';
		$keys['$UNWATCHURL'] = $this->title->getCanonicalUrl( 'action=unwatch' );

		# <Wikia>
		$keys['$ACTION'] = $this->action;
		// Hook registered in FollowHelper -- used for blogposts and categoryAdd
		wfRunHooks('MailNotifyBuildKeys', array( &$keys, $this->action, $this->otherParam ));
		# </Wikia>

		if ( $this->editor->isAnon() ) {
			# real anon (user:xxx.xxx.xxx.xxx)
			$keys['$PAGEEDITOR'] = wfMessage( 'enotif_anon_editor', $this->editor->getName() )->inContentLanguage()->plain();
			$keys['$PAGEEDITOR_EMAIL'] = wfMessage( 'noemailtitle' )->inContentLanguage()->plain();
		} else {
			$keys['$PAGEEDITOR'] = $wgEnotifUseRealName ? $this->editor->getRealName() : $this->editor->getName();
			$emailPage = SpecialPage::getSafeTitleFor( 'Emailuser', $this->editor->getName() );
			$keys['$PAGEEDITOR_EMAIL'] = $emailPage->getCanonicalUrl();
		}

		$keys['$PAGEEDITOR_WIKI'] = $this->editor->getUserPage()->getCanonicalUrl();

		# <Wikia>
		// RT #1294 Bartek 07.05.2009, use the language of the wiki
		$summary = ($this->summary == '') ? wfMessage( 'enotif_no_summary' )->inContentLanguage()->plain() : '"' . $this->summary . '"';
		# </Wikia>

		# Replace this after transforming the message, bug 35019
		$postTransformKeys['$PAGESUMMARY'] = $summary;

		# Now build message's subject and body
		# <Wikia>
		// ArticleComment -- updates subject and $keys['$PAGEEDITOR'] if anon editor
		// EmailTemplatesHooksHelper -- updates subject if blogpost
		// TopListHelper -- updates subject if title is toplist
		wfRunHooks('ComposeCommonSubjectMail', array( $this->title, &$keys, &$subject, $this->editor ));
		# </Wikia>
		$subject = strtr( $subject, $keys );
		$subject = MessageCache::singleton()->transform( $subject, false, null, $this->title );
		$this->subject = strtr( $subject, $postTransformKeys );

		// ArticleComment -- updates body and $keys['$PAGEEDITOR'] if anon editor
		// EmailTemplatesHooksHelper -- changes body to blog post. EmailTemplates only enabled on community and messaging so this tranforms
		//     any watched page email coming from Community to a blog post (I think)
		// TopListHelper -- updates body if title is toplist
		wfRunHooks('ComposeCommonBodyMail', array( $this->title, &$keys, &$body, $this->editor, &$bodyHTML, &$postTransformKeys ));
		$body = strtr( $body, $keys );
		$body = MessageCache::singleton()->transform( $body, false, null, $this->title );
		$this->body = wordwrap( strtr( $body, $postTransformKeys ), 72 );
		# <Wikia>
		if ($bodyHTML) {
			$bodyHTML = strtr( $bodyHTML, $keys );
			$bodyHTML = MessageCache::singleton()->transform( $bodyHTML, false, null, $this->title );
			$this->bodyHTML = strtr( $bodyHTML, $postTransformKeys );
		}
		# </Wikia>
	}

	/**
	 * Compose a mail to a given user and either queue it for sending, or send it now,
	 * depending on settings.
	 *
	 * Call sendMails() to send any mails that were queued.
	 * @param $user User
	 */
	private function compose( $user ) {
		if ( $this->isArticlePageEdit() ) {
			$this->sendUsingNewEmailExtension( $user );
		} else {
			$this->sendUsingUserMailer( $user );
		}

		wfRunHooks('NotifyOnPageChangeComplete', array( $this->title, $this->timestamp, &$user ));
	}

	/**
	 * Returns whether the email notification is for a watched article page which has been edited.
	 * If $this->action is empty and we have a previous Revision id it's an article page edit.
	 * The other possible values for action are categoryadd, blogpost, and article_comment.
	 * @return bool
	 */
	private function isArticlePageEdit() {
		return empty( $this->action ) && !$this->isNewPage();
	}


	/**
	 * When a page is created, the previousRevId is always 0.
	 * @return bool
	 */
	private function isNewPage() {
		return $this->previousRevId == 0;
	}

	/**
	 * Send a watched page edit email using the new Email extension.
	 * @param $user User
	 */
	private function sendUsingNewEmailExtension( $user ) {
		\F::app()->sendRequest( 'Email\Controller\WatchedPage', 'handle',
			[
				'targetUser' => $user->getName(),
				'title' => $this->title,
				'summary' => $this->summary,
				'currentRevId' => $this->currentRevId,
				'previousRevId' => $this->previousRevId,
				'timeStamp' => $this->timestamp,
				'replyToAddress' => $this->replyto,
				'fromAddress' => $this->from
			]);
	}

	private function sendUsingUserMailer( $user ) {
		if ( !$this->composedCommon ) {
			$this->composeCommonMailtext();
		}
		$this->sendPersonalised( $user );
	}

	/**
	 * Does the per-user customizations to a notification e-mail (name,
	 * timestamp in proper timezone, etc) and sends it out.
	 * Returns true if the mail was sent successfully.
	 *
	 * @param $watchingUser User object
	 * @return Boolean
	 * @private
	 */
	function sendPersonalised( $watchingUser ) {
		global $wgContLang, $wgEnotifUseRealName;
		// From the PHP manual:
		//     Note:  The to parameter cannot be an address in the form of "Something <someone@example.com>".
		//     The mail command will not parse this properly while talking with the MTA.
		$to = new MailAddress( $watchingUser );

		# $PAGEEDITDATE is the time and date of the page change
		# expressed in terms of individual local time of the notification
		# recipient, i.e. watching user
		$body = str_replace(
			array( '$WATCHINGUSERNAME',
				'$PAGEEDITDATE',
				'$PAGEEDITTIME' ),
			array( $wgEnotifUseRealName ? $watchingUser->getRealName() : $watchingUser->getName(),
				$wgContLang->userDate( $this->timestamp, $watchingUser ),
				$wgContLang->userTime( $this->timestamp, $watchingUser ) ),
			$this->body );

		# <Wikia>
		if ( $watchingUser->getOption('htmlemails') && !empty($this->bodyHTML) ) {
			$bodyHTML = str_replace(
				array( '$WATCHINGUSERNAME',
					'$PAGEEDITDATE',
					'$PAGEEDITTIME' ),
				array( $wgEnotifUseRealName ? $watchingUser->getRealName() : $watchingUser->getName(),
					$wgContLang->userDate( $this->timestamp, $watchingUser ),
					$wgContLang->userTime( $this->timestamp, $watchingUser ) ),
				$this->bodyHTML );
			# now body is array with text and html version of email
			$body = array( 'text' => $body, 'html' => $bodyHTML );
		}
		# </Wikia>
		UserMailer::send( $to, $this->from, $this->subject, $body, $this->replyto );
	}

	/**
	 * Returns whether the edited page is a User Talk page.
	 * @return bool
	 */
	private function isUserTalkPage() {
		return $this->title->getNamespace() == NS_USER_TALK;
	}
}
