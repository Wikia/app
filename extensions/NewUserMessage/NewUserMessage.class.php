<?php
/** Extension:NewUserMessage
 *
 * @file
 * @ingroup Extensions
 *
 * @author [http://www.organicdesign.co.nz/nad User:Nad]
 * @license GNU General Public Licence 2.0 or later
 * @copyright 2007-10-15 [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright 2009 Siebrand Mazeland
 */

if ( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

class NewUserMessage {

	/**
	 * Produce the editor for new user messages.
	 * @return User
	 */
	static function fetchEditor() {
		// Create a user object for the editing user and add it to the
		// database if it is not there already
		$editor = User::newFromName( wfMsgForContent( 'newusermessage-editor' ) );

		if( !$editor ) {
			return false; # Invalid user name
		}

		if ( !$editor->isLoggedIn() ) {
			$editor->addToDatabase();
		}

		return $editor;
	}

	/**
	 * Produce a (possibly random) signature.
	 * @return String
	 */
	static function fetchSignature() {
		$signatures = wfMsgForContent( 'newusermessage-signatures' );
		$signature = '';

		if ( !wfEmptyMsg( 'newusermessage-signatures', $signatures ) ) {
			$pattern = '/^\* ?(.*?)$/m';
			$signatureList = array();
			preg_match_all( $pattern, $signatures, $signatureList, PREG_SET_ORDER );
			if ( count( $signatureList ) > 0 ) {
				$rand = rand( 0, count( $signatureList ) - 1 );
				$signature = $signatureList[$rand][1];
			}
		}

		return $signature;
	}

	/**
	 * Return the template name if it exists, or '' otherwise.
	 * @return string
	 */
	static function fetchTemplateIfExists( $template ) {
		$text = Title::newFromText( $template );

		if ( !$text ) {
			wfDebug( __METHOD__ . ": '$template' is not a valid title.\n" );
			return '';
		} elseif ( $text->getNamespace() !== NS_TEMPLATE ) {
			wfDebug( __METHOD__ . ": '$template' is not a valid Template.\n" );
			return '';
		} elseif ( !$text->exists() ) {
			return '';
		}

		return $text->getText();
	}

	/**
	 * Produce a subject for the message.
	 * @return String
	 */
	static function fetchSubject() {
		return self::fetchTemplateIfExists( wfMsg( 'newusermessage-template-subject' ) );
	}

	/**
	 * Produce the template that contains the text of the message.
	 * @return String
	 */
	static function fetchText() {
		$template = wfMsg( 'newusermessage-template-body' );
		
		$title = Title::newFromText( $template );
		if ( $title && $title->exists() && $title->getLength() ) {
			return $template;
		}
		
		// Fall back if necessary to the old template
		return wfMsg( 'newusermessage-template' );
	}

	/**
	 * Produce the flags to set on Article::doEdit
	 * @return Int
	 */
	static function fetchFlags() {
		global $wgNewUserMinorEdit, $wgNewUserSuppressRC;

		$flags = EDIT_NEW;
		if ( $wgNewUserMinorEdit ) $flags = $flags | EDIT_MINOR;
		if ( $wgNewUserSuppressRC ) $flags = $flags | EDIT_SUPPRESS_RC;

		return $flags;
	}

	/**
	 * Take care of substition on the string in a uniform manner
	 * @param $str String
	 * @param $user User
	 * @param $editor User
	 * @param $talk Article
	 * @param $preparse if provided, then preparse the string using a Parser
	 * @return String
	 */
	static private function substString( $str, $user, $editor, $talk, $preparse = null ) {
		$realName = $user->getRealName();
		$name = $user->getName();

		// Add (any) content to [[MediaWiki:Newusermessage-substitute]] to substitute the
		// welcome template.
		$substitute = wfMsgForContent( 'newusermessage-substitute' );

		if ( $substitute ) {
			$str = '{{subst:' . "$str|realName=$realName|name=$name}}";
		} else {
			$str = '{{' . "$str|realName=$realName|name=$name}}";
		}

		if ( $preparse ) {
			global $wgParser;

			$str = $wgParser->preSaveTransform($str, $talk, $editor, new ParserOptions );
		}

		return $str;
	}

	/**
	 * Add the message if the users talk page does not already exist
	 * @param $user User object
	 */
	static function createNewUserMessage( $user ) {
		$talk = $user->getTalkPage();

		// Only leave message if user doesn't have a talk page yet
		if ( !$talk->exists() ) {
			$article = new Article( $talk );
			$subject = self::fetchSubject();
			$text = self::fetchText();
			$signature = self::fetchSignature();
			$editSummary = wfMsgForContent( 'newuseredit-summary' );
			$editor = self::fetchEditor();
			$flags = self::fetchFlags();

			# Do not add a message if the username is invalid or if the account that adds it, is blocked
			if( !$editor || $editor->isBlocked() ) {
				return true;
			}

			if ( $subject ) {
				$subject = self::substString( $subject, $user, $editor, $talk, "preparse" );
			}
			if ( $text ) {
				$text = self::substString( $text, $user, $editor, $talk );
			}

			self::leaveUserMessage( $user, $article, $subject, $text, 
				$signature, $editSummary, $editor, $flags );
		}
		return true;
	}

	/**
	 * Hook function to create a message on an auto-created user
	 * @param $user User object of the user
	 * @return bool
	 */
	static function createNewUserMessageAutoCreated( $user ) {
		global $wgNewUserMessageOnAutoCreate;

		if ( $wgNewUserMessageOnAutoCreate ) {
			NewUserMessage::createNewUserMessage( $user );
		}

		return true;
	}

	/**
	 * Hook function to provide a reserved name
	 * @param $names Array
	 */
	static function onUserGetReservedNames( &$names ) {
		$names[] = 'msg:newusermessage-editor';
		return true;
	}
	
	/**
	 * Leave a user a message
	 * @param $subject String the subject of the message
	 * @param $text String the message to leave
	 * @param $signature String Text to leave in the signature
	 * @param $summary String the summary for this change, defaults to
	 *                        "Leave system message."
	 * @param $editor User The user leaving the message, defaults to
	 *                        "{{MediaWiki:usermessage-editor}}"
	 * @param $flags Int default edit flags
	 *
	 * @return boolean true if it was successful
	 */
	public static function leaveUserMessage( $user, $article, $subject, $text, $signature,
			$summary, $editor, $flags ) {
		$text = self::formatUserMessage( $subject, $text, $signature );
		$flags = $article->checkFlags( $flags );

		if ( $flags & EDIT_UPDATE ) {
			$text = $article->getRawText() . "\n" . $text;
		}

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		try {
			$status = $article->doEdit( $text, $summary, $flags, false, $editor );
		} catch ( DBQueryError $e ) {
			$status = Status::newFatal( 'DB Error' );
		}

		if ( $status->isGood() ) {
			// Set newtalk with the right user ID
			$user->setNewtalk( true );
			$dbw->commit();
		} else {
			// The article was concurrently created
			wfDebug( __METHOD__ . ": Error ".$status->getWikiText() );
			$dbw->rollback();
		}

		return $status->isGood();
	}
	
	/**
	 * Format the user message using a hook, a template, or, failing these, a static format.
	 * @param $subject   String the subject of the message
	 * @param $text      String the content of the message
	 * @param $signature String the signature, if provided.
	 */
	static protected function formatUserMessage( $subject, $text, $signature ) {
		$contents = "";
		$signature = empty( $signature ) ? "~~~~" : "{$signature} ~~~~~";
		
		if ( $subject ) {
			$contents .= "== $subject ==\n\n";
		}
		$contents .= "$text\n\n-- $signature\n";

		return $contents;
	}
}
