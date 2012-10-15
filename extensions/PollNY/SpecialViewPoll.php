<?php
/**
 * A special page to view all available polls.
 * @file
 * @ingroup Extensions
 */
class ViewPoll extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'ViewPoll' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgScriptPath, $wgPollScripts;

		// Add CSS & JS
		$wgOut->addExtensionStyle( $wgPollScripts . '/Poll.css' );
		$wgOut->addScriptFile( $wgPollScripts . '/Poll.js' );

		// Page either most or newest for everyone
		$type = $wgRequest->getVal( 'type' );
		if( !$type ) {
			$type = 'most';
		}
		// ORDER BY for SQL query
		if( $type == 'newest' ) {
			$order = 'poll_id';
		}
		if( $type == 'most' ) {
			$order = 'poll_vote_count';
		}

		// Display only a user's most or newest
		$user_link = '';

		// Pagination
		$per_page = 20;
		$page = $wgRequest->getInt( 'page', 1 );

		$limit = $per_page;

		$limitvalue = 0;
		if ( $limit > 0 && $page ) {
			$limitvalue = $page * $limit - ( $limit );
		}

		// Safelinks
		$random_poll_link = SpecialPage::getTitleFor( 'RandomPoll' );

		$output = '
		<div class="view-poll-top-links">
			<a href="' . $random_poll_link->escapeFullURL() . '">' .
				wfMsg( 'poll-take-button' ) .
			'</a>
		</div>

		<div class="view-poll-navigation">
			<h2>' . wfMsg( 'poll-view-order' ) . '</h2>';

		$dbr = wfGetDB( DB_SLAVE );
		$where = array();

		$user = $wgRequest->getVal( 'user' );
		if ( $user ) {
			$where['poll_user_name'] = $dbr->strencode( $user );
			$user_link = '&user=' . urlencode( $user );
		}

		if ( $type == 'newest' ) {
			$output .= '<p><a href="' . $wgScriptPath . "/index.php?title=Special:ViewPoll&type=most{$user_link}\">" .
				wfMsg( 'poll-view-popular' ) . '</a></p><p><b>' .
				wfMsg( 'poll-view-newest' ) . '</b></p>';
		} else {
			$output .= '<p><b>' . wfMsg( 'poll-view-popular' ) .
				'</b></p><p><a href="' . $wgScriptPath .
				"/index.php?title=Special:ViewPoll&type=newest{$user_link}\">" .
				wfMsg( 'poll-view-newest' ) . '</a></p>';
		}

		$output .= '</div>';

		if ( isset( $user ) ) {
			$wgOut->setPageTitle( wfMsgExt( 'poll-view-title', 'parsemag', $user ) );
		} else {
			$wgOut->setPageTitle( wfMsgHtml( 'viewpoll' ) );
		}

		$res = $dbr->select(
			array( 'poll_question', 'page' ),
			array(
				'poll_user_id', 'UNIX_TIMESTAMP(poll_date) AS poll_time',
				'poll_vote_count', 'poll_user_name', 'poll_text',
				'poll_page_id', 'page_id'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => "$order DESC",
				'LIMIT' => $limit,
				'OFFSET' => $limitvalue
			),
			array( 'page' => array( 'INNER JOIN', 'poll_page_id = page_id' ) )
		);

		$res_total = $dbr->select(
			'poll_question',
			'COUNT(*) AS total_polls',
			( ( $user ) ? array( 'poll_user_name' => $dbr->strencode( $user ) ) : array() ),
			__METHOD__
		);
		$row_total = $dbr->fetchObject( $res_total );
		$total = $row_total->total_polls;

		$output .= '<div class="view-poll">';

		$x = ( ( $page - 1 ) * $per_page ) + 1;

		foreach ( $res as $row ) {
			$user_create = $row->poll_user_name;
			$user_id = $row->poll_user_id;
			$avatar = new wAvatar( $user_id, 'm' );
			$poll_title = $row->poll_text;
			$poll_date = $row->poll_time;
			$poll_answers = $row->poll_vote_count;
			$row_id = "poll-row-{$x}";
			$title = Title::makeTitle( NS_POLL, $poll_title );

			if( ( $x < $dbr->numRows( $res ) ) && ( $x % $per_page != 0 ) ) {
				$output .= "<div class=\"view-poll-row\" id=\"{$row_id}\" onmouseover=\"PollNY.doHover('{$row_id}')\" onmouseout=\"PollNY.endHover('{$row_id}')\" onclick=\"window.location='{$title->escapeFullURL()}'\">";
			} else {
				$output .= "<div class=\"view-poll-row-bottom\" id=\"{$row_id}\" onmouseover=\"PollNY.doHover('{$row_id}')\" onmouseout=\"PollNY.endHover('{$row_id}')\" onclick=\"window.location='{$title->escapeFullURL()}'\">";
			}

			$output .= "<div class=\"view-poll-number\">{$x}.</div>
					<div class=\"view-poll-user-image\">
						{$avatar->getAvatarURL()}
					</div>
					<div class=\"view-poll-user-name\">{$user_create}</div>
					<div class=\"view-poll-text\">
						<p><b><u>{$poll_title}</u></b></p>
						<p class=\"view-poll-num-answers\">" .
							wfMsgExt(
								'poll-view-answered-times',
								'parsemag',
								$poll_answers
							) . '</p>
						<p class="view-poll-time">(' .
							wfMsg(
								'poll-ago',
								Poll::getTimeAgo( $poll_date )
							) . ')</p>
					</div>
					<div class="cleared"></div>
				</div>';

			$x++;
		}

		$output .= '</div>
		<div class="cleared"></div>';

		$numofpages = $total / $per_page;

		if( $numofpages > 1 ) {
			$output .= '<div class="view-poll-page-nav">';
			if( $page > 1 ) {
				$output .= '<a href="' . $wgScriptPath . '/index.php?title=Special:ViewPoll&type=most' . $user_link . '&page=' . ( $page - 1 ) . '">' .
					wfMsg( 'poll-prev' ) . '</a> ';
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
					$output .= '<a href="' . $wgScriptPath . '/index.php?title=Special:ViewPoll&type=most' . $user_link . '&page=' . $i . '">' . $i . '</a> ';
				}
			}

			if( ( $total - ( $per_page * $page ) ) > 0 ) {
				$output .= ' <a href="' . $wgScriptPath . '/index.php?title=Special:ViewPoll&type=most' . $user_link . '&page=' . ( $page + 1 ) . '">' .
					wfMsg( 'poll-next' ) . '</a>';
			}
			$output .= '</div>';
		}

		$wgOut->addHTML( $output );
	}
}