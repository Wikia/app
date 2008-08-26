<?php

class TopUsersPoints extends SpecialPage {

	function TopUsersPoints(){
		SpecialPage::SpecialPage('TopUsers');
		wfLoadExtensionMessages('SocialProfileUserStats');
	}

	function execute(){
		global $IP, $wgUser, $wgOut, $wgStyleVersion, $wgScriptPath, $wgMemc, $wgUserStatsTrackWeekly, $wgUserStatsTrackMonthly, $wgUserLevels, $wgUploadPath;

		//read in localisation messages
		wfLoadExtensionMessages('SocialProfileUserStats');

		//Load CSS
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgScriptPath}/extensions/SocialProfile/UserStats/TopList.css?{$wgStyleVersion}\"/>\n");

		$wgOut->setPagetitle( wfMsg( 'user-stats-alltime-title') );

		$count = 50;

		$user_list = array();

		//try cache
		$key = wfMemcKey( 'user_stats', 'top', 'points', $count );
		$data = $wgMemc->get( $key );
		if( $data != ""){
			wfDebug("Got top users by points ({$count}) from cache\n");
			$user_list = $data;
		} else {
			wfDebug("Got top users by points ({$count}) from DB\n");

			$params['ORDER BY'] = 'stats_total_points DESC';
			$params['LIMIT'] = $count;
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( 'user_stats',
				array('stats_user_id','stats_user_name','stats_total_points'),
				array('stats_user_id <> 0'), __METHOD__,
				$params
			);
			while( $row = $dbr->fetchObject($res) ){
				$user_list[] = array(
						"user_id" => $row->stats_user_id,
						"user_name" => $row->stats_user_name,
						"points" => $row->stats_total_points
						);
			}
			$wgMemc->set( $key, $user_list, 60 * 5);
		}

		$recent_title = Title::makeTitle( NS_SPECIAL, 'TopUsersRecent' );

		$out .= "<div class=\"top-fan-nav\">
			<h1>" . wfMsg('top-fans-by-points-nav-header') . "</h1>
			<p><b>" . wfMsg('top-fans-total-points-link') . "</b></p>";

		if($wgUserStatsTrackWeekly) {
			$out .= "<p><a href=\"" . $recent_title->escapeFullURL("period=monthly") . "\">" . wfMsg('top-fans-monthly-points-link') . "</a><p>";
		}

		if($wgUserStatsTrackMonthly) {
			$out .= "<p><a href=\"" . $recent_title->escapeFullURL("period=weekly") . "\">" . wfMsg('top-fans-weekly-points-link') . "</a></p>";
		}

		//Build nav of stats by category based on MediaWiki:Topfans-by-category

		if (count($lines)>0) {
			$out .= "<h1 style=\"margin-top:15px !important;\">" . wfMsg('top-fans-by-category-nav-header') . "</h1>";
		}

		$by_category_title = Title::makeTitle( NS_SPECIAL, 'TopFansByStatistic');

		$lines = explode( "\n", wfMsgForContent( 'topfans-by-category' ) );
		foreach ($lines as $line) {

			if (strpos($line, '*') !== 0){
				continue;
			} else {
				$line = explode( '|' , trim($line, '* '), 2 );
				$stat = $line[0];
				$link_text = $line[1];
				$out .= "<p> <a href=\"" . $by_category_title->escapeFullURL("stat={$stat}") . "\">{$link_text}</a></p>";
			}
		}
		$out .= "</div>";

		$x = 1;
		$out .= "<div class=\"top-users\">";

		foreach( $user_list as $user ){

			$user_title = Title::makeTitle( NS_USER, $user["user_name"] );
			$avatar = new wAvatar( $user["user_id"], "m");
			$CommentIcon = $avatar->getAvatarImage();

			//Break list into sections based on User Level if its defined for this site
			if( is_array( $wgUserLevels ) ){
				$user_level = new UserLevel( number_format( $user["points"] ) );
				if( $user_level->getLevelName()!=$last_level ){
				    $out .= "<div class=\"top-fan-row\"><div class=\"top-fan-level\">
						{$user_level->getLevelName()}
						</div></div>";
				}
				$last_level = $user_level->getLevelName();
			}

			$out .= "<div class=\"top-fan-row\">
				<span class=\"top-fan-num\">{$x}.</span><span class=\"top-fan\">
				<img src='{$wgUploadPath}/avatars/" . $CommentIcon . "' alt='' border=''> <a href='" . $user_title->escapeFullURL() . "' >" . $user["user_name"] . "</a>
				</span>";

			$out .=  "<span class=\"top-fan-points\"><b>" . number_format( $user["points"] ) . "</b> " . wfMsg('top-fans-points') .
"</span>";
			$out .= "<div class=\"cleared\"></div>";
			$out .= "</div>";
			$x++;
		}
		$out .= "</div><div class=\"cleared\"></div>";
		$wgOut->addHTML($out);
	}
}
