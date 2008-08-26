<?php

class TopFansRecent extends UnlistedSpecialPage {

	function TopFansRecent(){
		UnlistedSpecialPage::UnlistedSpecialPage('TopUsersRecent');
	}

	function execute(){
		global $IP, $wgRequest, $wgUser, $wgOut, $wgStyleVersion, $wgMemc, $wgUserStatsTrackWeekly, $wgUserStatsTrackMonthly,
		$wgUserLevels, $wgUploadPath, $wgScriptPath;

		//read in localisation messages
		wfLoadExtensionMessages('SocialProfileUserStats');

		//Load CSS
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"".$wgScriptPath."/extensions/SocialProfile/UserStats/TopList.css?{$wgStyleVersion}\"/>\n");
		$period = $wgRequest->getVal("period");

		if(!$period)$period = "weekly";

		if($period=="weekly"){
			$wgOut->setPagetitle( wfMsg('user-stats-weekly-title') );
		} else {
			$wgOut->setPagetitle( wfMsg('user-stats-monthly-title') );
		}

		$count = 50;

		$user_list = array();

		//try cache
		$key = wfMemcKey( 'user_stats', $period, 'points', $count );
		$data = $wgMemc->get( $key );
		if( $data != ""){
			wfDebug("Got top users by {$period} points ({$count}) from cache\n");
			$user_list = $data;
		} else {
			wfDebug("Got top users by {$period} points ({$count}) from db\n");

			$params['ORDER BY'] = 'up_points DESC';
			$params['LIMIT'] = $count;

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select( "user_points_{$period}",
				array('up_user_id','up_user_name','up_points'),
				array('up_user_id <> 0'), __METHOD__,
				$params
			);
			while( $row = $dbr->fetchObject($res) ){
				$user_list[] = array(
						"user_id" => $row->up_user_id,
						"user_name" => $row->up_user_name,
						"points" => $row->up_points
						);
			}
			$wgMemc->set( $key, $user_list, 60 * 5);
		}

		//top nav bar
		$top_title = Title::makeTitle( NS_SPECIAL, 'TopUsers' );
		$recent_title = Title::makeTitle( NS_SPECIAL, 'TopUsersRecent' );

		$out .= "<div class=\"top-fan-nav\">
			<h1>" . wfMsg('top-fans-by-points-nav-header') . "</h1>
			<p><a href=\"{$top_title->escapeFullURL()}\">" . wfMsg('top-fans-total-points-link') . "</a></p>";

		if ($period=="weekly") {
			$out .= "<p><a href=\"" . $recent_title->escapeFullURL("period=monthly") . "\">" .wfMsg('top-fans-monthly-points-link') . "</a><p>
			<p><b>" . wfMsg('top-fans-weekly-points-link') . "</b></p>
			";
		} else {
			$out .= "<p><b>" .wfMsg('top-fans-monthly-points-link') . "</b><p>
			<p><a href=\"" . $recent_title->escapeFullURL("period=weekly") . "\">" .wfMsg('top-fans-weekly-points-link') . "</a></p>";
		}

		//Build nav of stats by category based on MediaWiki:Topfans-by-category
		if (count($lines)>0) {
			$out .= "<h1 style=\"margin-top:15px !important;\">" . wfMsg('top-fans-by-category-nav-header') . "</h1>";
		}

		$by_category_title = Title::makeTitle(NS_SPECIAL, 'TopFansByStatistic');
		$nav = array();

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
			$avatar = new wAvatar( $user["user_id"], "m" );
			$CommentIcon = $avatar->getAvatarImage();

			$out .= "<div class=\"top-fan-row\">
				<span class=\"top-fan-num\">{$x}.</span><span class=\"top-fan\">
				<img src='{$wgUploadPath}/avatars/" . $CommentIcon . "' alt='' border=''> <a href='" . $user_title->escapeFullURL() . "' >" . $user["user_name"] . "</a></span>";

			$out .=  "<span class=\"top-fan-points\"><b>" . number_format( $user["points"] ) . "</b> " . wfMsg('top-fans-points') . "</span>";
			$out .= "<div class=\"cleared\"></div>";
			$out .= "</div>";
			$x++;
		}
		$out .= "</div><div class=\"cleared\"></div>";
		$wgOut->addHTML($out);
	}
}
