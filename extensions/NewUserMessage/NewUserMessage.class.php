<?php
/** Extension:NewUserMessage
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author [http://www.organicdesign.co.nz/nad User:Nad]
 * @license GNU General Public Licence 2.0 or later
 * @copyright 2007-10-15 [http://www.organicdesign.co.nz/nad User:Nad]
 */

if (!defined('MEDIAWIKI'))
	die('Not an entry point.');

class NewUserMessage {
	/*
	 * Add the template message if the users talk page doesn't already exist
	 */
	static function createNewUserMessage($user) {
		$name = $user->getName();
		$talk = $user->getTalkPage();

		if (!$talk->exists()) {
			global $wgUser, $wgNewUserMinorEdit, $wgNewUserSuppressRC;

			wfLoadExtensionMessages( 'NewUserMessage' );

			$article = new Article($talk);

			// Create a user object for the editing user and add it to the database 
			// if it's not there already
			$editor = User::newFromName( wfMsgForContent( 'newusermessage-editor' ) );
			if ( !$editor->isLoggedIn() ) {
				$editor->addToDatabase();
			}

			$flags = EDIT_NEW;
			$templateTitleText = wfMsg( 'newusermessage-template' );
			$templateTitle = Title::newFromText( $templateTitleText );
			if ( !$templateTitle ) {
				wfDebug( __METHOD__. ": invalid title in newusermessage-template\n" );
				return true;
			}
			if ( $templateTitle->getNamespace() == NS_TEMPLATE ) {
				$templateTitleText = $templateTitle->getText();
			}
			if ($wgNewUserMinorEdit) $flags = $flags | EDIT_MINOR;
			if ($wgNewUserSuppressRC) $flags = $flags | EDIT_SUPPRESS_RC;

			$dbw = wfGetDB( DB_MASTER );
			$dbw->begin();
			$good = true;

			$text = "{{{$templateTitleText}|$name}}";
			$signatures = wfMsgForContent( 'newusermessage-signatures' );
			if ( !wfEmptyMsg( 'newusermessage-signatures', $signatures ) ) {
				$pattern = '/^\* ?(.*?)$/m';
				preg_match_all( $pattern, $signatures, $signatureList, PREG_SET_ORDER );
				if ( count( $signatureList ) > 0 ) {
					$rand = rand( 0, count( $signatureList ) - 1 );
					$signature = $signatureList[$rand][1];
					$text .= "\n-- {$signature} ~~~~~";
				}
			}
			try {
				$article->doEdit( $text, wfMsgForContent( 'newuseredit-summary' ), $flags, false, $editor );
			} catch ( DBQueryError $e ) {
				$good = false;
			}

			if ( $good ) {
				// Set newtalk with the right user ID
				$user->setNewtalk( true );
				$dbw->commit();
			} else {
				// The article was concurrently created
				wfDebug( __METHOD__. ": the article has already been created despite !\$talk->exists()\n" );
				$dbw->rollback();
			}
		}
		return true;
	}

	static function createNewUserMessageAutoCreated( $user ) {
		global $wgNewUserMessageOnAutoCreate;

		if( $wgNewUserMessageOnAutoCreate ) {
			NewUserMessage::createNewUserMessage( $user );
		}

		return true;
	}

	static function onUserGetReservedNames( &$names ) {
		wfLoadExtensionMessages( 'NewUserMessage' );
		$names[] = 'msg:newusermessage-editor';
		return true;
	}
}
