<?php
/**
* ReassignEdits
*
* @package MediaWiki
* @subpackage Extensions
*
* @author: Tim 'SVG' Weyer <SVG@Wikiunity.com>
*
* @copyright Copyright (C) 2011 Tim Weyer, Wikiunity
* @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*
*/

if (!defined('MEDIAWIKI')) {
	echo "ReassignEdits extension";
	exit(1);
}

class SpecialReassignEdits extends SpecialPage {
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ReassignEdits', 'reassignedits' );
	}

	/**
	 * Show the special page
	 *
	 * @param mixed $par Parameter passed to the page
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest, $wgContLang;
		global $wgCapitalLinks;

		$this->setHeaders();
		$wgOut->addWikiMsg( 'reassignedits-summary' );

		// If the user doesn't have 'reassignedits' permission, display an error
		if ( !$wgUser->isAllowed( 'reassignedits' ) ) {
			$this->displayRestrictionError();
			return;
		}

		// Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$oldnamePar = trim( str_replace( '_', ' ', $wgRequest->getText( 'oldusername', $par ) ) );
		$oldusername = Title::makeTitle( NS_USER, $oldnamePar );
		// Force uppercase of newusername, otherwise wikis with wgCapitalLinks=false can create lc usernames
		$newusername = Title::makeTitleSafe( NS_USER, $wgContLang->ucfirst( $wgRequest->getText( 'newusername' ) ) );
		$oun = is_object( $oldusername ) ? $oldusername->getText() : '';
		$nun = is_object( $newusername ) ? $newusername->getText() : '';
		$token = $wgUser->editToken();

		$updatelogging_user = $wgRequest->getBool( 'updatelogginguser', !$wgRequest->wasPosted());
		$updatelogging_title = $wgRequest->getCheck( 'updateloggingtitle' );

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl(), 'id' => 'reassignedits' ) ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'reassignedits' ) ) .
			Xml::openElement( 'table', array( 'id' => 'mw-reassignedits-table' ) ) .
			"<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'reassignedits-old' ), 'oldusername' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'oldusername', 20, $oun, array( 'type' => 'text', 'tabindex' => '1' ) ) . ' ' .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'reassignedits-new' ), 'newusername' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'newusername', 20, $nun, array( 'type' => 'text', 'tabindex' => '2' ) ) .
				"</td>
			</tr>"
		);
		$wgOut->addHTML( "
			<tr>
				<td>&#160;
				</td>
				<td class='mw-input'>" .
					Xml::checkLabel( wfMsg( 'reassignedits-updatelog-user' ), 'updatelogginguser', 'updatelogginguser',
						$updatelogging_user, array( 'tabindex' => '3' ) ) .
				"</td>
			</tr>"
		);
		$wgOut->addHTML( "
			<tr>
				<td>&#160;
				</td>
				<td class='mw-input'>" .
					Xml::checkLabel( wfMsg( 'reassignedits-updatelog-title' ), 'updateloggingtitle', 'updateloggingtitle',
						$updatelogging_title, array( 'tabindex' => '4' ) ) .
				"</td>
			</tr>"
		);
		$wgOut->addHTML( "
			<tr>
				<td>&#160;
				</td>
				<td class='mw-submit'>" .
					Xml::submitButton( wfMsg( 'reassignedits-submit' ), array( 'name' => 'submit',
						'tabindex' => '5', 'id' => 'submit' ) ) .
				"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Html::hidden( 'token', $token ) .
			Xml::closeElement( 'form' ) . "\n"
		);

		if ( $wgRequest->getText( 'token' ) === '' ) {
			// They probably haven't even submitted the form, so don't go further
			return;
		} elseif ( !$wgRequest->wasPosted() || !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
			$wgOut->addWikiText( "<div class=\"errorbox\">" . wfMsg( 'reassignedits-error-request' ) . "</div>" );
			return;
		} elseif ( !is_object( $oldusername ) ) {
			$wgOut->addWikiText(
				"<div class=\"errorbox\">"
				. wfMsg( 'reassignedits-error-invalid', $wgRequest->getText( 'oldusername' ) )
				. "</div>"
			);
			return;
		} elseif ( !is_object( $newusername ) ) {
			$wgOut->addWikiText(
				"<div class=\"errorbox\">"
				. wfMsg( 'reassignedits-error-invalid', $wgRequest->getText( 'newusername' ) )
				. "</div>"
			);
			return;
		}

		// Get usernames by id
		$newuser = User::newFromName( $newusername->getText() );

		// It won't be an object if for instance "|" is supplied as a value
		if ( !is_string( $oldusername->getText() ) ) {
			$wgOut->addWikiText( "<div class=\"errorbox\">" . wfMsg( 'reassignedits-error-invalid',
				$oldusername->getText() ) . "</div>" );
			return;
		}
		if ( !is_object( $newuser ) ) {
			$wgOut->addWikiText( "<div class=\"errorbox\">" . wfMsg( 'reassignedits-error-invalid',
				$newusername->getText() ) . "</div>" );
			return;
		}

		// Do the heavy lifting...
		$reassign = new ReassignEditsSQL( $oldusername->getText(), $newusername->getText() );
		if ( !$reassign->reassign() ) {
			return;
		}

		// Output success message
		$wgOut->addWikiText( "<div class=\"successbox\">" . wfMsg( 'reassignedits-success', $oldusername->getText(),
		$newusername->getText() ) . "</div><br style=\"clear:both\" />" );
	}
}

class ReassignEditsSQL {
	/**
	  * The old username
	  *
	  * @var string
	  * @access private
	  */
	var $old;

	/**
	  * The new username
	  *
	  * @var string
	  * @access private
	  */
	var $new;

	/**
	 * Constructor
	 *
	 * @param string $old The old username
	 * @param string $new The new username
	 */
	function __construct( $old, $new ) {
		$this->old = $old;
		$this->new = $new;
	}

	/**
	 * Do the reassign operation
	 */
	function reassign() {
		global $wgRequest;

		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();

		$newname = $this->new;
		$newid = User::idFromName( $this->new );
		$oldname = $this->old;

		// Update archive table (deleted revisions)
		$dbw->update( 'archive',
			array( 'ar_user_text' => $newname, 'ar_user' => $newid ),
			array( 'ar_user_text' => $oldname ),
			__METHOD__ );
		// Update user in logging table if checkbox is true
		if ( $wgRequest->getCheck( 'updatelogginguser' ) ) {
			$dbw->update( 'logging',
				array( 'log_user_text' => $newname, 'log_user' => $newid ),
				array( 'log_user_text' => $oldname ),
				__METHOD__ );
		}
		// Update title in logging table if checkbox is true
		if ( $wgRequest->getCheck( 'updateloggingtitle' ) ) {
			$oldTitle = Title::makeTitle( NS_USER, $this->old );
			$newTitle = Title::makeTitle( NS_USER, $this->new );
			$dbw->update( 'logging',
				array( 'log_title' => $newTitle->getDBkey() ),
				array( 'log_type' => array( 'block', 'rights' ),
					'log_namespace' => NS_USER,
					'log_title' => $oldTitle->getDBkey() ),
				__METHOD__ );
		}
		// Update revision table
		$dbw->update( 'revision',
			array( 'rev_user_text' => $newname, 'rev_user' => $newid ),
			array( 'rev_user_text' => $oldname ),
			__METHOD__ );

		// Commit the transaction
		$dbw->commit();

		wfProfileOut( __METHOD__ );
		return true;
	}
}
