<?php

/**
 * Class file for the Patroller extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

class Patroller extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Patrol', 'patroller' );
	}

	/**
	 * @param $par Parameters passed to the page
	 */
	public function execute( $par ) {
		global $wgUser, $wgRequest, $wgOut;

		wfLoadExtensionMessages( 'Patroller' );

		$this->setHeaders();

		# Check permissions
		if( !$wgUser->isAllowed( 'patroller' ) ) {
			$wgOut->permissionRequired( 'patroller' );
			return;
		}

		# Keep out blocked users
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		# Prune old assignments if needed
		wfSeedRandom();
		if( 0 == mt_rand( 0, 499 ) )
			$this->pruneAssignments();

		# See if something needs to be done
		if( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getText( 'wpToken' ) ) ) {
			if( $rcid = $wgRequest->getIntOrNull( 'wpRcId' ) ) {
				if( $wgRequest->getCheck( 'wpPatrolEndorse' ) ) {
					# Mark the change patrolled
					if( !$wgUser->isBlocked( false ) ) {
						RecentChange::markPatrolled( $rcid );
						$wgOut->setSubtitle( wfMsgHtml( 'patrol-endorsed-ok' ) );
					} else {
						$wgOut->setSubtitle( wfMsgHtml( 'patrol-endorsed-failed' ) );
					}
				} elseif( $wgRequest->getCheck( 'wpPatrolRevert' ) ) {
					# Revert the change
					$edit = $this->loadChange( $rcid );
					$msg = $this->revert( $edit, $this->revertReason( $wgRequest ) ) ? 'ok' : 'failed';
					$wgOut->setSubtitle( wfMsgHtml( 'patrol-reverted-' . $msg ) );
				} elseif( $wgRequest->getCheck( 'wpPatrolSkip' ) ) {
					# Do bugger all, for now
					$wgOut->setSubtitle( wfMsgHtml( 'patrol-skipped-ok' ) );
				}
			}
		}

		# If a token was passed, but the check box value was not, then
		# the user wants to pause or stop patrolling
		if( $wgRequest->getCheck( 'wpToken' ) && !$wgRequest->getCheck( 'wpAnother' ) ) {
			$skin =& $wgUser->getSkin();
			$self = Title::makeTitle( NS_SPECIAL, 'Patrol' );
			$link = $skin->makeKnownLinkObj( $self, wfMsgHtml( 'patrol-resume' ) );
			$wgOut->addHtml( wfMsgWikiHtml( 'patrol-stopped', $link ) );
			return;
		}

		# Pop an edit off recentchanges
		$haveEdit = false;
		while( !$haveEdit ) {
			$edit = $this->fetchChange( $wgUser );
			if( $edit ) {
				# Attempt to assign it
				if( $this->assignChange( $edit ) ) {
					$haveEdit = true;
					$this->showDiffDetails( $edit );
					$wgOut->addHtml( '<br /><hr />' );
					$this->showDiff( $edit );
					$wgOut->addHtml( '<br /><hr />' );
					$this->showControls( $edit );
				}
			} else {
				# Can't find a suitable edit
				$haveEdit = true; # Don't keep going, there's nothing to find
				$wgOut->addWikiText( wfMsg( 'patrol-nonefound' ) );
			}
		}
	}

	/**
	 * Produce a stub recent changes listing for a single diff.
	 *
	 * @param $edit Diff. to show the listing for
	 */
	private function showDiffDetails( &$edit ) {
		global $wgUser, $wgOut;
		$edit->counter = 1;
		$edit->mAttribs['rc_patrolled'] = 1;
		$list = ChangesList::newFromUser( $wgUser );
		$wgOut->addHtml( $list->beginRecentChangesList() .
						 $list->recentChangesLine( $edit ) .
						 $list->endRecentChangesList() );
	}

	/**
	 * Output a trimmed down diff view corresponding to a particular change
	 *
	 * @param $edit Recent change to produce a diff. for
	 */
	private function showDiff( &$edit ) {
		$diff = new DifferenceEngine( $edit->getTitle(), $edit->mAttribs['rc_last_oldid'], $edit->mAttribs['rc_this_oldid'] );
		$diff->showDiff( '', '' );
	}

	/**
	 * Output a bunch of controls to let the user endorse, revert and skip changes
	 *
	 * @param $edit RecentChange being dealt with
	 */
	private function showControls( &$edit ) {
		global $wgUser, $wgOut;
		$self = Title::makeTitle( NS_SPECIAL, 'Patrol' );
		$form = wfOpenElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= '<table>';
		$form .= '<tr><td align="right">' . wfSubmitButton( wfMsg( 'patrol-endorse' ), array( 'name' => 'wpPatrolEndorse' ) ) . '</td><td></td></tr>';
		$form .= '<tr><td align="right">' . wfSubmitButton( wfMsg( 'patrol-revert' ), array( 'name' => 'wpPatrolRevert' ) ) . '</td>';
		$form .= '<td>' . wfLabel( wfMsg( 'patrol-revert-reason' ), 'reason' ) . '&nbsp;';
		$form .= $this->revertReasonsDropdown() . ' / ' . wfInput( 'wpPatrolRevertReason' ) . '</td></tr>';
		$form .= '<tr><td align="right">' . wfSubmitButton( wfMsg( 'patrol-skip' ), array( 'name' => 'wpPatrolSkip' ) ) . '</td></tr></table>';
		$form .= '<tr><td>' . wfCheck( 'wpAnother', true ) . '</td><td>' . wfMsgHtml( 'patrol-another' ) . '</td></tr>';
		$form .= wfHidden( 'wpRcId', $edit->mAttribs['rc_id'] );
		$form .= wfHidden( 'wpToken', $wgUser->editToken() );
		$form .= '</form>';
		$wgOut->addHtml( $form );
	}

	/**
	 * Fetch a recent change which
	 *   - the user doing the patrolling didn't cause
	 *   - wasn't due to a bot
	 *   - hasn't been patrolled
	 *   - isn't assigned to a user
	 *
	 * @param $user User to suppress edits for
	 * @return RecentChange
	 */
	private function fetchChange( &$user ) {
		$dbr =& wfGetDB( DB_SLAVE );
		$uid = $user->getId();
		extract( $dbr->tableNames( 'recentchanges', 'patrollers', 'page' ) );
		$sql = "SELECT * FROM $page, $recentchanges LEFT JOIN $patrollers ON rc_id = ptr_change
				WHERE rc_namespace = page_namespace AND rc_title = page_title
				AND rc_this_oldid = page_latest AND rc_bot = 0 AND rc_patrolled = 0 AND rc_type = 0
				AND rc_user != $uid AND ptr_timestamp IS NULL LIMIT 0,1";
		$res = $dbr->query( $sql, 'Patroller::fetchChange' );
		if( $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$dbr->freeResult( $res );
			return RecentChange::newFromRow( $row, $row->rc_last_oldid );
		} else {
			$dbr->freeResult( $res );
			return false;
		}
	}

	/**
	 * Fetch a particular recent change given the rc_id value
	 *
	 * @param $rcid rc_id value of the row to fetch
	 * @return RecentChange
	 */
	private function loadChange( $rcid ) {
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'recentchanges', '*', array( 'rc_id' => $rcid ), 'Patroller::loadChange' );
		if( $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			return RecentChange::newFromRow( $row );
		} else {
			return false;
		}
	}

	/**
	 * Assign the patrolling of a particular change, so
	 * other users don't pull it up, duplicating effort
	 *
	 * @param $edit RecentChange item to assign
	 * @return bool
	 */
	private function assignChange( &$edit ) {
		$dbw =& wfGetDB( DB_MASTER );
		$val = array( 'ptr_change' => $edit->mAttribs['rc_id'], 'ptr_timestamp' => $dbw->timestamp() );
		$res = $dbw->insert( 'patrollers', $val, 'Patroller::assignChange', 'IGNORE' );
		return (bool)$dbw->affectedRows();
	}

	/**
	 * Remove the assignment for a particular change, to let another user handle it
	 *
	 * @todo Use it or lose it
	 * @param $rcid rc_id value
	 */
	private function unassignChange( $rcid ) {
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->delete( 'patrollers', array( 'ptr_change' => $rcid ), 'Patroller::unassignChange' );
	}

	/**
	 * Prune old assignments from the table so edits aren't
	 * hidden forever because a user wandered off, and to
	 * keep the table size down as regards old assignments
	 */
	private function pruneAssignments() {
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->delete( 'patrollers', array( 'ptr_timestamp < ' . $dbw->timestamp( time() - 120 ) ), 'Patroller::pruneAssignments' );
	}

	/**
	 * Revert a change, setting the page back to the "old" version
	 *
	 * @param $edit RecentChange to revert
	 * @param $comment Comment to use when reverting
	 */
	private function revert( &$edit, $comment = '' ) {
		global $wgUser;
		if( !$wgUser->isBlocked( false ) ) { # Check block against master
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->begin();
			$title = $edit->getTitle();
			# Prepare the comment
			$comment = wfMsgForContent( 'patrol-reverting', $comment );
			# Find the old revision
			$old = Revision::newFromId( $edit->mAttribs['rc_last_oldid'] );
			# Be certain we're not overwriting a more recent change
			# If we would, ignore it, and silently consider this change patrolled
			$latest = (int)$dbw->selectField( 'page', 'page_latest', array( 'page_id' => $title->getArticleId() ), __METHOD__ );
			if( $edit->mAttribs['rc_this_oldid'] == $latest ) {
				# Revert the edit; keep the reversion itself out of recent changes
				wfDebugLog( 'patroller', 'Reverting "' . $title->getPrefixedText() . '" to r' . $old->getId() );
				$article = new Article( $title );
				$article->doEdit( $old->getText(), $comment, EDIT_UPDATE & EDIT_MINOR & EDIT_SUPPRESS_RC );
			}
			$dbw->commit();
			# Mark the edit patrolled so it doesn't bother us again
			RecentChange::markPatrolled( $edit->mAttribs['rc_id'] );
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Make a nice little drop-down box containing all the pre-defined revert
	 * reasons for simplified selection
	 *
	 * @return string
	 */
	private function revertReasonsDropdown() {
		$msg = wfMsgForContent( 'patrol-reasons' );
		if( $msg == '-' || $msg == '&lt;patrol-reasons&gt;' ) {
			return '';
		} else {
			$reasons = array();
			$lines = explode( "\n", $msg );
			foreach( $lines as $line ) {
				if( substr( $line, 0, 1 ) == '*' )
					$reasons[] = trim( $line, '* ' );
			}
			if( count( $reasons ) > 0 ) {
				$box = wfOpenElement( 'select', array( 'name' => 'wpPatrolRevertReasonCommon' ) );
				foreach( $reasons as $reason )
					$box .= wfElement( 'option', array( 'value' => $reason ), $reason );
				$box .= wfCloseElement( 'select' );
				return $box;
			} else {
				return '';
			}
		}
	}

	/**
	 * Determine which of the two "revert reason" form fields to use;
	 * the pre-defined reasons, or the nice custom text box
	 *
	 * @param $request WebRequest object to test
	 * @return string
	 */
	private function revertReason( &$request ) {
		$custom = $request->getText( 'wpPatrolRevertReason' );
		return trim( $custom ) != ''
				? $custom
				: $request->getText( 'wpPatrolRevertReasonCommon' );
	}
}
