<?php
/**
 * A special page to administer existing polls (i.e. examine flagged ones,
 * delete them and so on).
 * @file
 * @ingroup Extensions
 */
class AdminPoll extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'AdminPoll', 'polladmin' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser, $wgUploadPath, $wgHooks, $wgPollScripts;

		// If the user doesn't have the required permission, display an error
		if( !$wgUser->isAllowed( 'polladmin' ) ) {
			$wgOut->permissionRequired( 'polladmin' );
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

		// Add CSS & JS
		$wgOut->addExtensionStyle( $wgPollScripts . '/Poll.css' );
		$wgOut->addScriptFile( $wgPollScripts . '/Poll.js' );

		// Add i18n JS variables via a hook (yes, this works, I've tested this)
		$wgHooks['MakeGlobalVariablesScript'][] = 'AdminPoll::addJSGlobals';

		// Pagination
		$per_page = 20;
		$page = $wgRequest->getInt( 'page', 1 );

		$current_status = $wgRequest->getVal( 'status' );
		if( !$current_status ) {
			$current_status = 'all';
		}

		$limit = $per_page;

		$nav = array(
			'all' => wfMsg( 'poll-admin-viewall' ),
			'open' => wfMsg( 'poll-admin-open' ),
			'closed' => wfMsg( 'poll-admin-closed' ),
			'flagged' => wfMsg( 'poll-admin-flagged' )
		);

		$output = '<div class="view-poll-top-links">
			<a href="javascript:history.go(-1);">' . wfMsg( 'poll-take-button' ) . '</a>
		</div>

		<div class="view-poll-navigation">
			<h2>' . wfMsg( 'poll-admin-status-nav' ) . '</h2>';

		foreach( $nav as $status => $title ) {
			$output .= '<p>';
			if( $current_status != $status ) {
				$output .= '<a href="' . $this->getTitle()->escapeFullURL( "status={$status}" ) . "\">{$title}</a>";
			} else {
				$output .= "<b>{$title}</b>";
			}

			$output .= '</p>';
		}

		$output .= '</div>';

		$wgOut->setPageTitle( wfMsg( 'poll-admin-title-' . $current_status ) );

		$params['ORDER BY'] = 'poll_date DESC';
		if( $limit > 0 ) {
			$params['LIMIT'] = $limit;
		}
		if( $page ) {
			$params['OFFSET'] = $page * $limit - ( $limit );
		}

		$status_int = -1;
		switch( $current_status ) {
			case 'open':
				$status_int = 1;
				break;
			case 'closed':
				$status_int = 0;
				break;
			case 'flagged':
				$status_int = 2;
				break;
		}
		$where = array();
		if( $status_int > -1 ) {
			$where['poll_status'] = $status_int;
		}

		$dbr = wfGetDB( DB_MASTER );
		$res = $dbr->select(
			array( 'poll_question', 'page' ),
			array(
				'poll_id', 'poll_user_id',
				'UNIX_TIMESTAMP(poll_date) AS poll_time', 'poll_status',
				'poll_vote_count', 'poll_user_name', 'poll_text',
				'poll_page_id', 'page_id'
			),
			$where,
			__METHOD__,
			$params,
			array( 'page' => array( 'INNER JOIN', 'poll_page_id = page_id' ) )
		);

		if( $status_int > -1 ) {
			$where['poll_status'] = $status;
		}

		$s = $dbr->selectRow(
			'poll_question',
			array( 'COUNT(*) AS count' ),
			$where,
			__METHOD__,
			$params
		);

		$total = $s->count;

		$output .= '<div class="view-poll">';

		$x = ( ( $page - 1 ) * $per_page ) + 1;

		// If we have nothing, show an error(-ish) message, but don't return
		// because it could be that we have plenty of polls in the database,
		// but none of 'em matches the given criteria (status param in the URL)
		// For example, there are no flagged polls or closed polls. This msg
		// gets shown even then.
		if ( !$dbr->numRows( $res ) ) {
			$wgOut->addWikiMsg( 'poll-admin-no-polls' );
		}

		foreach ( $res as $row ) {
			$user_create = $row->poll_user_name;
			$user_id = $row->poll_user_id;
			$avatar = new wAvatar( $user_id, 'm' );
			$poll_title = $row->poll_text;
			$poll_date = $row->poll_time;
			$poll_answers = $row->poll_vote_count;
			$rowId = "poll-row-{$x}";
			$title = Title::makeTitle( NS_POLL, $poll_title );

			$p = new Poll();
			$poll_choices = $p->getPollChoices( $row->poll_id );

			if( ( $x < $dbr->numRows( $res ) ) && ( $x % $per_page != 0 ) ) {
				$output .= "<div class=\"view-poll-row\" id=\"{$rowId}\">";
			} else {
				$output .= "<div class=\"view-poll-row-bottom\" id=\"{$rowId}\">";
			}

			$output .= "<div class=\"view-poll-number\">{$x}.</div>
					<div class=\"view-poll-user-image\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" alt=\"\" /></div>
					<div class=\"view-poll-user-name\">{$user_create}</div>
					<div class=\"view-poll-text\">
					<p><b><a href=\"{$title->escapeFullURL()}\">{$poll_title}</a></b></p>
					<p>";
			foreach( $poll_choices as $choice ) {
				$output .= "{$choice['choice']}<br />";
			}
			$output .= '</p>
						<p class="view-poll-num-answers">' .
							wfMsgExt(
								'poll-view-answered-times',
								'parsemag',
								$poll_answers
							) . '</p>
						<p class="view-poll-time">(' .
							wfMsg(
								'poll-ago',
								Poll::getTimeAgo( $poll_date )
							) . ")</p>
						<div id=\"poll-{$row->poll_id}-controls\">";
			if( $row->poll_status == 2 ) {
				$output .= "<a href=\"javascript:void(0)\" onclick=\"PollNY.poll_admin_status({$row->poll_id},1);\">" .
					wfMsg( 'poll-unflag-poll' ) . '</a>';
			}
			if( $row->poll_status == 0 ) {
				$output .= " <a href=\"javascript:void(0)\" onclick=\"PollNY.poll_admin_status({$row->poll_id},1);\">" .
					wfMsg( 'poll-open-poll' ) . '</a>';
			}
			if( $row->poll_status == 1 ) {
				$output .= " <a href=\"javascript:void(0)\" onclick=\"PollNY.poll_admin_status({$row->poll_id},0);\">" .
					wfMsg( 'poll-close-poll' ) . '</a>';
			}
			$output .= " <a href=\"javascript:void(0)\" onclick=\"PollNY.poll_delete({$row->poll_id});\">" .
				wfMsg( 'poll-delete-poll' ) . '</a>
						</div>
					</div>
					<div class="cleared"></div>
				</div>';

			$x++;
		}

		$output .= '</div>
		<div class="cleared"></div>';

		$output .= $this->buildPagination( $total, $per_page, $page );

		$wgOut->addHTML( $output );
	}

	/**
	 * Build the pagination links.
	 *
	 * @param $total Integer: amount of all polls in the database
	 * @param $perPage Integer: how many items to show per page? This is
	 *                          hardcoded to 20 earlier in this file
	 * @param $page Integer: number indicating on which page we are
	 * @return String: HTML
	 */
	public function buildPagination( $total, $perPage, $page ) {
		$output = '';
		$numofpages = $total / $perPage;
		$viewPoll = SpecialPage::getTitleFor( 'ViewPoll' );
		if( $numofpages > 1 ) {
			$output .= '<div class="view-poll-page-nav">';
			if( $page > 1 ) {
				$output .= '<a href="' . $viewPoll->getFullURL(
					array(
						'type' => 'most',
						'page' => ( $page - 1 )
					)
				) . '">' . wfMsg( 'poll-prev' ) . '</a> ';
			}

			if( ( $total % $per_page ) != 0 ) {
				$numofpages++;
			}
			if( $numofpages >= 9 && $page < $total ) {
				$numofpages = 9 + $page;
			}
			if( $numofpages >= ( $total / $per_page ) ) {
				$numofpages = ( $total / $per_page ) + 1;
			}

			for( $i = 1; $i <= $numofpages; $i++ ) {
				if( $i == $page ) {
					$output .= ( $i . ' ' );
				} else {
					$output .= '<a href="' . $viewPoll->getFullURL(
						array(
							'type' => 'most',
							'page' => $i
						)
					) . "\">$i</a> ";
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $viewPoll->getFullURL(
					array(
						'type' => 'most',
						'page' => ( $page + 1 )
					)
				) . '">' . wfMsg( 'poll-next' ) . '</a>';
			}
			$output .= '</div>';
		}
		return $output;
	}

	/**
	 * Add some new JS globals (i18n messages) so that the poll admin JS can
	 * display localized output
	 *
	 * @param $vars Array: array of pre-existing JS globals
	 * @return Boolean: true
	 */
	public static function addJSGlobals( &$vars ) {
		$vars['_POLL_OPEN_MESSAGE'] = wfMsg( 'poll-open-message' );
		$vars['_POLL_CLOSE_MESSAGE'] = wfMsg( 'poll-close-message' );
		$vars['_POLL_FLAGGED_MESSAGE'] = wfMsg( 'poll-flagged-message' );
		$vars['_POLL_DELETE_MESSAGE'] = wfMsg( 'poll-delete-message' );
		return true;
	}
}
