<?php
class UniwikiFormatChanges {
	public function UW_FormatChanges( $user, $skin, $list ) {
		$list = new UniwikiChangesList( $skin );
		return false;
	}
}

class UniwikiChangesList extends ChangesList {

	public function recentChangesLine( &$rc, $watched = false ) {
		global $wgLang;

		// set local vars (this apparently does that)
		extract( $rc->mAttribs );

		$this->insertDateHeader( $line, $rc_timestamp );

		/* NOTE: the following logic is reproduced from
		 *       the old version of the recent changes
		 *       page in case we want to produce a
		 *       similar result (though much is not
		 *       implemented yet)...
		 */

		// moved pages
		if ( $rc_type == RC_MOVE || $rc_type == RC_MOVE_OVER_REDIRECT ) {
			// handle these?
		}
		// log entries(old) and special pages
		else if ( $rc_namespace == NS_SPECIAL ) {
			// handle these?
		}
		// new unpatrolled pages
		else if ( isset( $rc->unpatrolled ) && $rc_type == RC_NEW ) {
			// handle these?
		}
		// log entries
		else if ( $rc_type == RC_LOG ) {
			// handle these?
		}
		// edits and new pages
		else {
			wfLoadExtensionMessages( 'FormatChanges' );

			$line .= "<li>";
			$page_link = $this->skin->makeKnownLinkObj( $rc->getTitle(), '' );
			if ( $this->isDeleted( $rc, Revision::DELETED_USER ) ) {
				$user_link = '<span class="history-deleted">' . wfMsgHtml( 'rev-deleted-user' ) . '</span>';
			} else {
				$user_link = ( $rc_user > 0 ) ? $this->skin->userLink( $rc_user, $rc_user_text ) : wfMsg( 'formatchanges-anonymous' );
			}
			$timestamp = $wgLang->time( $rc->mAttribs['rc_timestamp'], true, true );

			if ( $rc_type == RC_NEW ) {
				$line .= wfMsgHtml( 'formatchanges-createdby', $page_link, $user_link, $timestamp );
			} else {
				$line .= wfMsgHtml( 'formatchanges-editedby', $page_link, $user_link, $timestamp );
			}
			$line .= "</li>";
		}

		return $line;
	}
}
