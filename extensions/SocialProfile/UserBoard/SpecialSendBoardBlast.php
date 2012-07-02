<?php
/**
 * A special page to allow users to send a mass board message by selecting from
 * a list of their friends and foes
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialBoardBlast extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'SendBoardBlast' );
	}

	/**
	 * Show the special page
	 *
	 * @param $params Mixed: parameter(s) passed to the page or null
	 */
	public function execute( $params ) {
		global $wgRequest, $wgOut, $wgUser, $wgUserBoardScripts;

		// This feature is available only to logged-in users.
		if ( !$wgUser->isLoggedIn() ) {
			$wgOut->setPageTitle( wfMsg( 'boardblastlogintitle' ) );
			$wgOut->addWikiMsg( 'boardblastlogintext' );
			return '';
		}

		// Is the database locked?
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return false;
		}

		// Blocked through Special:Block? No access for you!
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage( false );
			return false;
		}

		// Add CSS & JS
		$wgOut->addExtensionStyle( $wgUserBoardScripts . '/BoardBlast.css' );
		$wgOut->addScriptFile( $wgUserBoardScripts . '/BoardBlast.js' );

		$output = '';

		if ( $wgRequest->wasPosted() ) {
			$wgOut->setPageTitle( wfMsg( 'messagesenttitle' ) );
			$b = new UserBoard();

			$count = 0;
			$user_ids_to = explode( ',', $wgRequest->getVal( 'ids' ) );
			foreach ( $user_ids_to as $user_id ) {
				$user = User::newFromId( $user_id );
				$user->loadFromId();
				$user_name = $user->getName();
				$b->sendBoardMessage(
					$wgUser->getID(),
					$wgUser->getName(),
					$user_id,
					$user_name,
					$wgRequest->getVal( 'message' ),
					1
				);
				$count++;
			}
			$output .= wfMsg( 'messagesentsuccess' );
		} else {
			$wgOut->setPageTitle( wfMsg( 'boardblasttitle' ) );
			$output .= $this->displayForm();
		}

		$wgOut->addHTML( $output );
	}

	/**
	 * Displays the form for sending board blasts
	 */
	function displayForm() {
		global $wgUser;

		$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
		$stats_data = $stats->getUserStats();
		$friendCount = $stats_data['friend_count'];
		$foeCount = $stats_data['foe_count'];

		$output = '<div class="board-blast-message-form">
				<h2>' . wfMsg( 'boardblaststep1' ) . '</h2>
				<form method="post" name="blast" action="">
					<input type="hidden" name="ids" id="ids" />
					<div class="blast-message-text">'
						. wfMsg( 'boardblastprivatenote' ) .
					'</div>
					<textarea name="message" id="message" cols="63" rows="4"></textarea>
				</form>
		</div>
		<div class="blast-nav">
				<h2>' . wfMsg( 'boardblaststep2' ) . '</h2>
				<div class="blast-nav-links">
					<a href="javascript:void(0);" onclick="javascript:BoardBlast.selectAll()">' .
						wfMsg( 'boardlinkselectall' ) . '</a> -
					<a href="javascript:void(0);" onclick="javascript:BoardBlast.unselectAll()">' .
						wfMsg( 'boardlinkunselectall' ) . '</a> ';

		if ( $friendCount > 0 && $foeCount > 0 ) {
			$output .= '- <a href="javascript:void(0);" onclick="javascript:BoardBlast.toggleFriends(1)">' .
				wfMsg( 'boardlinkselectfriends' ) . '</a> -';
			$output .= '<a href="javascript:void(0);" onclick="javascript:BoardBlast.toggleFriends(0)">' .
				wfMsg( 'boardlinkunselectfriends' ) . '</a>';
		}

		if ( $foeCount > 0 && $friendCount > 0 ) {
			$output .= '- <a href="javascript:void(0);" onclick="javascript:BoardBlast.toggleFoes(1)">' .
				wfMsg( 'boardlinkselectfoes' ) . '</a> -';
			$output .= '<a href="javascript:void(0);" onclick="javascript:BoardBlast.toggleFoes(0)">' .
				wfMsg( 'boardlinkunselectfoes' ) . '</a>';
		}
		$output .= '</div>
		</div>';

		$rel = new UserRelationship( $wgUser->getName() );
		$relationships = $rel->getRelationshipList();

		$output .= '<div id="blast-friends-list" class="blast-friends-list">';

		$x = 1;
		$per_row = 3;
		if ( count( $relationships ) > 0 ) {
			foreach ( $relationships as $relationship ) {
				if ( $relationship['type'] == 1 ) {
					$class = 'friend';
				} else {
					$class = 'foe';
				}
				$id = $relationship['user_id'];
				$output .= '<div class="blast-' . $class . "-unselected\" id=\"user-{$id}\" onclick=\"javascript:BoardBlast.toggleUser({$id})\">
						{$relationship['user_name']}
					</div>";
				if ( $x == count( $relationships ) || $x != 1 && $x % $per_row == 0 ) {
					$output .= '<div class="cleared"></div>';
				}
				$x++;
			}
		} else {
			$output .= '<div>' . wfMsg( 'boardnofriends' ) . '</div>';
		}

		$output .= '</div>

			<div class="cleared"></div>';

		$output .= '<div class="blast-message-box-button">
			<input type="button" value="' . wfMsg( 'boardsendbutton' ) . '" class="site-button" onclick="javascript:BoardBlast.sendMessages();" />
		</div>';

		return $output;
	}
}
