<?php

class TopUsersPoints extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'TopUsers' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgScriptPath, $wgMemc, $wgUserStatsTrackWeekly, $wgUserStatsTrackMonthly, $wgUserLevels;

		// Load CSS
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserStats/TopList.css' );

		$wgOut->setPageTitle( wfMsg( 'user-stats-alltime-title' ) );

		$count = 100;
		$realcount = 50;

		$user_list = array();

		// Try cache
		$key = wfMemcKey( 'user_stats', 'top', 'points', $realcount );
		$data = $wgMemc->get( $key );
		if ( $data != '' ) {
			wfDebug( "Got top users by points ({$count}) from cache\n" );
			$user_list = $data;
		} else {
			wfDebug( "Got top users by points ({$count}) from DB\n" );

			$params['ORDER BY'] = 'stats_total_points DESC';
			$params['LIMIT'] = $count;
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'user_stats',
				array( 'stats_user_id', 'stats_user_name', 'stats_total_points' ),
				array( 'stats_user_id <> 0' ),
				__METHOD__,
				$params
			);
			$loop = 0;
			foreach ( $res as $row ) {
				$user = User::newFromId( $row->stats_user_id );
				if ( !$user->isBlocked() ) {
					$user_list[] = array(
						'user_id' => $row->stats_user_id,
						'user_name' => $row->stats_user_name,
						'points' => $row->stats_total_points
					);
					$loop++;
				}
				if ( $loop >= $realcount ) {
					break;
				}
			}
			$wgMemc->set( $key, $user_list, 60 * 5 );
		}

		$recent_title = SpecialPage::getTitleFor( 'TopUsersRecent' );

		$out = '<div class="top-fan-nav">
			<h1>' . wfMsg( 'top-fans-by-points-nav-header' ) . '</h1>
			<p><b>' . wfMsg( 'top-fans-total-points-link' ) . '</b></p>';

		if ( $wgUserStatsTrackWeekly ) {
			$out .= '<p><a href="' . $recent_title->escapeFullURL( 'period=monthly' ) . '">' .
				wfMsg( 'top-fans-monthly-points-link' ) . '</a></p>';
		}

		if ( $wgUserStatsTrackMonthly ) {
			$out .= '<p><a href="' . $recent_title->escapeFullURL( 'period=weekly' ) . '">' .
				wfMsg( 'top-fans-weekly-points-link' ) . '</a></p>';
		}

		// Build nav of stats by category based on MediaWiki:Topfans-by-category
		$by_category_title = SpecialPage::getTitleFor( 'TopFansByStatistic' );

		$byCategoryMessage = wfMsgForContent( 'topfans-by-category' );

		if ( !wfEmptyMsg( 'topfans-by-category', $byCategoryMessage ) ) {
			$out .= '<h1 style="margin-top:15px !important;">' .
				wfMsg( 'top-fans-by-category-nav-header' ) . '</h1>';

			$lines = explode( "\n", $byCategoryMessage );
			foreach ( $lines as $line ) {
				if ( strpos( $line, '*' ) !== 0 ) {
					continue;
				} else {
					$line = explode( '|' , trim( $line, '* ' ), 2 );
					$stat = $line[0];
					$link_text = $line[1];
					$statURL = $by_category_title->escapeFullURL( "stat={$stat}" );
					$out .= '<p> <a href="' . $statURL . "\">{$link_text}</a></p>";
				}
			}
		}

		$out .= '</div>';

		$x = 1;
		$out .= '<div class="top-users">';
		$last_level = '';

		foreach ( $user_list as $user ) {
			$user_title = Title::makeTitle( NS_USER, $user['user_name'] );
			$avatar = new wAvatar( $user['user_id'], 'm' );
			$commentIcon = $avatar->getAvatarURL();

			// Break list into sections based on User Level if it's defined for this site
			if ( is_array( $wgUserLevels ) ) {
				$user_level = new UserLevel( number_format( $user['points'] ) );
				if ( $user_level->getLevelName() != $last_level ) {
					$out .= "<div class=\"top-fan-row\"><div class=\"top-fan-level\">
						{$user_level->getLevelName()}
						</div></div>";
				}
				$last_level = $user_level->getLevelName();
			}

			$out .= "<div class=\"top-fan-row\">
				<span class=\"top-fan-num\">{$x}.</span>
				<span class=\"top-fan\">
					{$commentIcon} <a href='" . $user_title->escapeFullURL() . "'>" .
						$user['user_name'] . '</a>
				</span>';

			$out .= '<span class="top-fan-points"><b>' . number_format( $user['points'] ) . '</b> ' . wfMsg( 'top-fans-points' ) . '</span>';
			$out .= '<div class="cleared"></div>';
			$out .= '</div>';
			$x++;
		}

		$out .= '</div><div class="cleared"></div>';
		$wgOut->addHTML( $out );
	}
}
