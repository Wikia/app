<?php

class TopFansByStat extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'TopFansByStatistic' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut, $wgMemc, $wgUserStatsTrackWeekly, $wgUserStatsTrackMonthly,
			$wgUserLevels, $wgUploadPath, $wgScriptPath;

		// Read in localisation messages
		wfLoadExtensionMessages( 'SocialProfileUserStats' );

		// Load CSS
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserStats/TopList.css' );

		$dbr = wfGetDB( DB_SLAVE );

		$statistic = $dbr->strencode( trim( $wgRequest->getVal( 'stat' ) ) );
		$column = "stats_{$statistic}";

		// Error if the querystring value does not match our stat column
		if ( !$dbr->fieldExists( 'user_stats', $column ) ) {
			$wgOut->setPageTitle( wfMsg( 'top-fans-bad-field-title' ) );
			$wgOut->addHTML( wfMsg( 'top-fans-bad-field-message' ) );
			return false;
		}

		// Fix i18n message key
		$fixedStatistic = str_replace( '_', '-', $statistic );
		// Set page title
		$wgOut->setPageTitle( wfMsg( 'top-fans-by-category-title-' . $fixedStatistic ) );

		$count = 50;

		$user_list = array();

		// Get list of users
		// Try cache
		$key = wfMemcKey( 'user_stats', 'top', $statistic, $count );
		$data = $wgMemc->get( $key );
		if ( $data != '' ) {
			wfDebug( "Got top users by {$statistic} ({$count}) from cache\n" );
			$user_list = $data;
		} else {
			wfDebug( "Got top users by {$statistic} ({$count}) from DB\n" );

			$params['ORDER BY'] = "{$column} DESC";
			$params['LIMIT'] = $count;

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				'user_stats',
				array( 'stats_user_id', 'stats_user_name', $column ),
				array( 'stats_user_id <> 0', "{$column} > 0" ),
				__METHOD__,
				$params
			);
			foreach ( $res as $row ) {
				$user_list[] = array(
					'user_id' => $row->stats_user_id,
					'user_name' => $row->stats_user_name,
					'stat' => $row->$column
				);
			}
			$wgMemc->set( $key, $user_list, 60 * 5 );
		}

		// Top nav bar
		$top_title = SpecialPage::getTitleFor( 'TopUsers' );
		$recent_title = SpecialPage::getTitleFor( 'TopUsersRecent' );

		$out = '<div class="top-fan-nav">
			<h1>' . wfMsg( 'top-fans-by-points-nav-header' ) . '</h1>
			<p><a href="' . $top_title->escapeFullURL() . '">' . wfMsg( 'top-fans-total-points-link' ) . '</a></p>';

		if ( $wgUserStatsTrackWeekly ) {
			$out .= '<p><a href="' . $recent_title->escapeFullURL( 'period=monthly' ) . '">' . wfMsg( 'top-fans-monthly-points-link' ) . '</a><p>';
		}
		if ( $wgUserStatsTrackMonthly ) {
			$out .= '<p><a href="' . $recent_title->escapeFullURL( 'period=weekly' ) . '">' . wfMsg( 'top-fans-weekly-points-link' ) . '</a></p>';
		}

		// Build nav of stats by category based on MediaWiki:Topfans-by-category
		$out .= '<h1 style="margin-top:15px !important;">' . wfMsg( 'top-fans-by-category-nav-header' ) . '</h1>';

		$by_category_title = SpecialPage::getTitleFor( 'TopFansByStatistic' );
		$nav = array();

		$lines = explode( "\n", wfMsgForContent( 'topfans-by-category' ) );
		foreach ( $lines as $line ) {
			if ( strpos( $line, '*' ) !== 0 ) {
				continue;
			} else {
				$line = explode( '|', trim( $line, '* ' ), 2 );
				$stat = $line[0];
				$link_text = $line[1];
				$out .= '<p><a href="' . $by_category_title->escapeFullURL( "stat={$stat}" ) . '">' . $link_text . '</a></p>';
			}
		}
		$out .= '</div>';

		$x = 1;
		$out .= '<div class="top-users">';

		foreach ( $user_list as $user ) {
			if ( $user['user_name'] == substr( $user['user_name'], 0, 22 ) ) {
				$user_name = $user['user_name'];
			} else {
				$user_name = substr( $user['user_name'], 0, 22 ) . wfMsg( 'ellipsis' );
			}
			$user_title = Title::makeTitle( NS_USER, $user['user_name'] );
			$avatar = new wAvatar( $user['user_id'], 'm' );
			$commentIcon = $avatar->getAvatarImage();

			// Stats row
			// TODO: opinion_average isn't currently working, so it's not enabled in menus
			if ( $statistic == 'opinion_average' ) {
				$statistics_row = number_format( $row->opinion_average, 2 );
				$lowercase_statistics_name = 'percent';
			} else {
				global $wgLang;
				$statistics_row = number_format( $user['stat'] );
				$lowercase_statistics_name = $wgLang->lc( wfMsgExt( "top-fans-stats-{$fixedStatistic}", 'parsemag', $user['stat'] ) );
			}

			$out .= '<div class="top-fan-row">
				<span class="top-fan-num">' . $x . '.</span>
				<span class="top-fan">
					<img src="' . $wgUploadPath . '/avatars/' . $commentIcon . '" alt="" border="" />
					<a href="' . $user_title->escapeFullURL() . '">' . $user_name . '</a>
				</span>
				<span class="top-fan-points"><b>' . $statistics_row . '</b> ' . $lowercase_statistics_name . '</span>
				<div class="cleared"></div>
			</div>';
			$x++;
		}
		$out .= '</div><div class="cleared"></div>';
		$wgOut->addHTML( $out );
	}
}
