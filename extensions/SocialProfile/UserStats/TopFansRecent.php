<?php

class TopFansRecent extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'TopUsersRecent' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut, $wgMemc, $wgScriptPath;

		// Load CSS
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SocialProfile/UserStats/TopList.css' );

		$periodFromRequest = $wgRequest->getVal( 'period' );
		if ( $periodFromRequest == 'weekly' ) {
			$period = 'weekly';
		} elseif ( $periodFromRequest == 'monthly' ) {
			$period = 'monthly';
		}

		if ( !isset( $period ) ) {
			$period = 'weekly';
		}

		if ( $period == 'weekly' ) {
			$wgOut->setPageTitle( wfMsg( 'user-stats-weekly-title' ) );
		} else {
			$wgOut->setPageTitle( wfMsg( 'user-stats-monthly-title' ) );
		}

		$count = 50;

		$user_list = array();

		// Try cache
		$key = wfMemcKey( 'user_stats', $period, 'points', $count );
		$data = $wgMemc->get( $key );
		if ( $data != '' ) {
			wfDebug( "Got top users by {$period} points ({$count}) from cache\n" );
			$user_list = $data;
		} else {
			wfDebug( "Got top users by {$period} points ({$count}) from DB\n" );

			$params['ORDER BY'] = 'up_points DESC';
			$params['LIMIT'] = $count;

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				"user_points_{$period}",
				array( 'up_user_id', 'up_user_name', 'up_points' ),
				array( 'up_user_id <> 0' ),
				__METHOD__,
				$params
			);
			foreach ( $res as $row ) {
				$user_list[] = array(
					'user_id' => $row->up_user_id,
					'user_name' => $row->up_user_name,
					'points' => $row->up_points
				);
			}
			$wgMemc->set( $key, $user_list, 60 * 5 );
		}

		// Top nav bar
		$top_title = SpecialPage::getTitleFor( 'TopUsers' );
		$recent_title = SpecialPage::getTitleFor( 'TopUsersRecent' );

		$out = '<div class="top-fan-nav">
			<h1>' . wfMsg( 'top-fans-by-points-nav-header' ) . '</h1>
			<p><a href="' . $top_title->escapeFullURL() . '">' .
				wfMsg( 'top-fans-total-points-link' ) . '</a></p>';

		if ( $period == 'weekly' ) {
			$out .= '<p><a href="' . $recent_title->escapeFullURL( 'period=monthly' ) . '">' .
				wfMsg( 'top-fans-monthly-points-link' ) . '</a><p>
			<p><b>' . wfMsg( 'top-fans-weekly-points-link' ) . '</b></p>';
		} else {
			$out .= '<p><b>' . wfMsg( 'top-fans-monthly-points-link' ) . '</b><p>
			<p><a href="' . $recent_title->escapeFullURL( 'period=weekly' ) . '">' .
				wfMsg( 'top-fans-weekly-points-link' ) . '</a></p>';
		}

		// Build nav of stats by category based on MediaWiki:Topfans-by-category
		$by_category_title = SpecialPage::getTitleFor( 'TopFansByStatistic' );
		$message = wfMsgForContent( 'topfans-by-category' );

		if ( !wfEmptyMsg( 'topfans-by-category', $message ) ) {
			$out .= '<h1 class="top-title">' .
				wfMsg( 'top-fans-by-category-nav-header' ) . '</h1>';

			$lines = explode( "\n", $message );
			foreach ( $lines as $line ) {
				if ( strpos( $line, '*' ) !== 0 ) {
					continue;
				} else {
					$line = explode( '|', trim( $line, '* ' ), 2 );
					$stat = $line[0];
					$link_text = $line[1];
					$statURL = $by_category_title->escapeFullURL( "stat={$stat}" );
					$out .= '<p><a href="' . $statURL . '">' . $link_text . '</a></p>';
				}
			}
		}

		$out .= '</div>';

		$x = 1;
		$out .= '<div class="top-users">';

		foreach ( $user_list as $user ) {
			$user_title = Title::makeTitle( NS_USER, $user['user_name'] );
			$avatar = new wAvatar( $user['user_id'], 'm' );
			$avatarImage = $avatar->getAvatarURL();

			$out .= '<div class="top-fan-row">
				<span class="top-fan-num">' . $x . '.</span>
				<span class="top-fan">' .
					$avatarImage .
					'<a href="' . $user_title->escapeFullURL() . '" >' . $user['user_name'] . '</a>
				</span>';

			$out .= '<span class="top-fan-points"><b>' .
				number_format( $user['points'] ) . '</b> ' .
				wfMsg( 'top-fans-points' ) . '</span>';
			$out .= '<div class="cleared"></div>';
			$out .= '</div>';
			$x++;
		}

		$out .= '</div><div class="cleared"></div>';
		$wgOut->addHTML( $out );
	}
}
