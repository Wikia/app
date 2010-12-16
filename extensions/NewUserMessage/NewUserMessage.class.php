<?php
/** Extension:NewUserMessage
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author [http://www.organicdesign.co.nz/nad User:Nad]
 * @license GNU General Public Licence 2.0 or later
 * @copyright 2007-10-15 [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright 2009 Siebrand Mazeland
 */

if ( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

class NewUserMessage {
	/*
	 * Add the template message if the users talk page does not already exist
	 */
	static function createNewUserMessage( $user ) {
		$talk = $user->getTalkPage();

		if ( !$talk->exists() ) {
			global $wgUser, $wgLqtTalkPages;

			$name = $user->getName();
			$realName = $user->getRealName();

			wfLoadExtensionMessages( 'NewUserMessage' );

			$article = new Article( $talk );
			$editSummary = wfMsgForContent( 'newuseredit-summary' );

			// Create a user object for the editing user and add it to the
			// database if it is not there already
			$editor = User::newFromName( wfMsgForContent( 'newusermessage-editor' ) );
			if ( !$editor->isLoggedIn() ) {
				$editor->addToDatabase();
			}

			// Add (any) content to [[MediaWiki:Newusermessage-substitute]] to substitute the welcome template.
			$substitute = wfMsgForContent( 'newusermessage-substitute' );

			if ( $wgLqtTalkPages && LqtDispatch::isLqtPage( $talk ) ) { // Create a thread on the talk page if LiquidThreads is installed
				// Get subject text
				$threadSubject = self::getTextForPageInKey( 'newusermessage-template-subject' );

				// Do not continue if there is no valid subject title
				if ( !$threadSubject ) {
					wfDebug( __METHOD__ . ": no text found for the subject\n" );
					return true;
				}

				/** Create the final subject text.
				 * Always substituted and processed by parser to avoid awkward subjects
				 * Use real name if new user provided it
				 */
				$parser = new Parser;
				$parser->setOutputType( 'wiki' );
				$parserOptions = new ParserOptions;

				if ( $realName ) {
					$threadSubject = $parser->preSaveTransform(
						"{{subst:{$threadSubject}|$realName}}",
						$talk /* as dummy */,
						$editor, $parserOptions
					);
				} else {
					$threadSubject = $parser->preSaveTransform(
						"{{subst:{$threadSubject}|$name}}",
						$talk /* as dummy */,
						$editor,
						$parserOptions
					);
				}

				// Get the body text
				$threadBody = self::getTextForPageInKey( 'newusermessage-template-body' );

				// Do not continue if there is no body text
				if ( !$threadBody ) {
					wfDebug( __METHOD__ . ": no text found for the body\n" );
					return true;
				}

				// Create the final body text after checking if the template is to be substituted.
				if ( $substitute ) {
					$threadBody = "{{subst:{$threadBody}|$name|$realName}}";
				} else {
					$threadBody = "{{{$threadBody}|$name|$realName}}";
				}

				$threadTitle = Threads::newThreadTitle( $threadSubject, $article );

				if ( !$threadTitle ) {
					wfDebug( __METHOD__ . ": invalid title $threadTitle\n" );
					return true;
				}

				$threadArticle = new Article( $threadTitle );
				self::writeWelcomeMessage( $user, $threadArticle,  $threadBody, $editSummary, $editor );

				// Need to edit as another user. Lqt does not provide an interface to alternative users,
				// so replacing $wgUser here.
				$parkedUser = $wgUser;
				$wgUser = $editor;
				
				LqtView::newPostMetadataUpdates(
					array(
						'talkpage' => $article,
						'text' => $threadBody,
						'summary' => $editSummary,
						'root' => $threadArticle,
						'subject' => $threadSubject,
					)
				);

				// Set $wgUser back to the newly created user
				$wgUser = $parkedUser;
			} else { // Processing without LiquidThreads
				$templateTitleText = wfMsg( 'newusermessage-template' );
				$templateTitle = Title::newFromText( $templateTitleText );
				if ( !$templateTitle ) {
					wfDebug( __METHOD__ . ": invalid title in newusermessage-template\n" );
					return true;
				}

				if ( $templateTitle->getNamespace() == NS_TEMPLATE ) {
					$templateTitleText = $templateTitle->getText();
				}

				if ( $substitute ) {
					$text = "{{subst:{$templateTitleText}|$name|$realName}}";
				} else {
					$text = "{{{$templateTitleText}|$name|$realName}}";
				}

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

				self::writeWelcomeMessage( $user, $article,  $text, $editSummary, $editor );
			}
		}
		return true;
	}

	static function createNewUserMessageAutoCreated( $user ) {
		global $wgNewUserMessageOnAutoCreate;

		if ( $wgNewUserMessageOnAutoCreate ) {
			NewUserMessage::createNewUserMessage( $user );
		}

		return true;
	}

	static function onUserGetReservedNames( &$names ) {
		wfLoadExtensionMessages( 'NewUserMessage' );
		$names[] = 'msg:newusermessage-editor';
		return true;
	}

	/**
	 * Create a page with text
	 * @param $user User object: user that was just created
	 * @param $article Article object: the article where $text is to be put
	 * @param $text String: text to put in $article
	 * @param $summary String: edit summary text
	 * @param $editor User object: user that will make the edit
	 */
	private static function writeWelcomeMessage( $user, $article, $text, $summary, $editor ) {
		global $wgNewUserMinorEdit, $wgNewUserSuppressRC;

		wfLoadExtensionMessages( 'NewUserMessage' );

		$flags = EDIT_NEW;
		if ( $wgNewUserMinorEdit ) $flags = $flags | EDIT_MINOR;
		if ( $wgNewUserSuppressRC ) $flags = $flags | EDIT_SUPPRESS_RC;

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$good = true;

		try {

			$article->doEdit( $text, $summary, $flags, false, $editor );
		} catch ( DBQueryError $e ) {
			$good = false;
			}

		if ( $good ) {
			// Set newtalk with the right user ID
			$user->setNewtalk( true );
			$dbw->commit();
		} else {
			// The article was concurrently created
			wfDebug( __METHOD__ . ": the article has already been created despite !\$talk->exists()\n" );
			$dbw->rollback();
		}
	}

	/**
	 * Returns the text contents of a template page set in given key contents
	 * Returns empty string if no text could be retrieved.
	 * @param $key String: message key that should contain a template page name
	 */
	private static function getTextForPageInKey( $key ) {
		$templateTitleText = wfMsgForContent( $key );
		$templateTitle = Title::newFromText( $templateTitleText );

		// Do not continue if there is no valid subject title
		if ( !$templateTitle ) {
			wfDebug( __METHOD__ . ": invalid title in " . $key . "\n" );
			return '';
		}

		// Get the subject text from the page
		if ( $templateTitle->getNamespace() == NS_TEMPLATE ) {
			return $templateTitle->getText();
		} else {
			// There is no subject text
			wfDebug( __METHOD__ . ": " . $templateTitleText . " must be in NS_TEMPLATE\n" );
			return '';
		}
	}
}
