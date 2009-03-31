<?php
/* vim: noet ts=4 sw=4
 * http://www.gnu.org/licenses/gpl-3.0.txt */

if ( !defined( "MEDIAWIKI" ) )
	die();

$wgExtensionCredits['other'][] = array(
	'name'           => 'FormatChanges',
	'author'         => 'Merrick Schaefer, Mark Johnston, Evan Wheeler and Adam Mckaig (at UNICEF)',
	'description'    => 'Reformats the [[Special:RecentChanges|recent changes]]',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Uniwiki_Format_Changes',
	'svn-date'       => '$LastChangedDate: 2008-12-28 21:01:55 +0000 (Sun, 28 Dec 2008) $',
	'svn-revision'   => '$LastChangedRevision: 45137 $',
	'descriptionmsg' => 'formatchanges-desc',
);

$wgExtensionMessagesFiles['FormatChanges'] = dirname( __FILE__ ) . '/FormatChanges.i18n.php';

/* ---- HOOKS ---- */
$wgHooks['FetchChangesList'][] = "UW_FormatChanges";

// FIXME: split off into a class file. See ChangesList.php for example.
function UW_FormatChanges( $user, $skin, $list ) {
	$list = new UniwikiChangesList( $skin );
	return false;
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
