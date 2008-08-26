<?php

$wgExtensionFunctions[] = 'wfSpecialTopFansRecent';


function wfSpecialTopFansRecent(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class TopFansRecent extends UnlistedSpecialPage {
	
		function TopFansRecent(){
			UnlistedSpecialPage::UnlistedSpecialPage("TopUsersRecent");
		}
	
		function execute(){
			global $IP, $wgRequest, $wgUser, $wgOut, $wgStyleVersion, $wgMessageCache, $wgMemc, $wgUserStatsTrackWeekly, 
			       $wgUserStatsTrackMonthly, $wgUserLevels, $wgUploadPath; 
	
			//read in localisation messages
			require_once ( "$IP/extensions/wikia/UserStats/UserStats.i18n.php" );
			foreach( efWikiaUserStats() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
			
			//load css
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/UserStats/TopList.css?{$wgStyleVersion}\"/>\n");
			
			$period = $wgRequest->getVal("period");
			if(!$period)$period="weekly";
			
			if($period=="weekly"){
				$wgOut->setPagetitle( wfMsg( "user_stats_weekly_title") );
			}else{
				$wgOut->setPagetitle( wfMsg( "user_stats_monthly_title") );
			}			
			
			$count = 50;
			
			$user_list = array();
			
			//try cache
			$key = wfMemcKey( 'user_stats', $period , 'points', $count );
			$data = $wgMemc->get( $key );
			if( $data != ""){
				wfDebug("Got top users by {$period} points ({$count}) from cache\n");
				$user_list = $data;
			}else{
				wfDebug("Got top users by {$period} points ({$count}) from db\n");
			
				$params['ORDER BY'] = 'up_points DESC';
				$params['LIMIT'] = $count;
				
				$dbr =& wfGetDB( DB_SLAVE );
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
			
			$top_title = Title::makeTitle( NS_SPECIAL  , "TopUsers"  );
			$recent_title = Title::makeTitle( NS_SPECIAL  , "TopUsersRecent"  );
			
			$out .= "<div class=\"top-fan-nav\">
				<h1>" . wfMsg("top_fans_by_points_nav_header") . "</h1>
				<p><a href=\"{$top_title->escapeFullURL()}\">" . wfMsg("top_fans_total_points_link") . "</a></p>";
			
			if ($period=="weekly") {
				$out .= "<p><a href=\"" . $recent_title->escapeFullURL("period=monthly") . "\">" .wfMsg("top_fans_monthly_points_link") . "</a><p>
				<p><b>" . wfMsg("top_fans_weekly_points_link") . "</b></p>
				";
			} else {
				$out .= "<p><b>" .wfMsg("top_fans_monthly_points_link") . "</b><p>
				<p><a href=\"" . $recent_title->escapeFullURL("period=weekly") . "\">" .wfMsg("top_fans_weekly_points_link") . "</a></p>";
			}
				
			//Build Nav of Stats by Category based on Mediawiki:topfans_by_category
			
			if (count($lines)>0) {
				$out .= "<h1 style=\"margin-top:15px !important;\">" . wfMsg("top_fans_by_category_nav_header") . "</h1>";
			}
			
			$by_category_title = Title::makeTitle( NS_SPECIAL, "TopFansByStatistic");
			$nav = array();
			
			$lines = explode( "\n", wfMsgForContent( 'topfans_by_category' ) );
			foreach ($lines as $line) {
				
				if (strpos($line, '*') !== 0){
					continue;
				}else{
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
				$user_title = Title::makeTitle( NS_USER  , $user["user_name"]  );
				$avatar = new wAvatar( $user["user_id"] ,"m");
				$CommentIcon = $avatar->getAvatarImage();
				
				$out .= "<div class=\"top-fan-row\">
					<span class=\"top-fan-num\">{$x}.</span><span class=\"top-fan\">
					<img src='{$wgUploadPath}/avatars/" . $CommentIcon . "' alt='' border=''> <a href='" . $user_title->escapeFullURL() . "' >" . $user["user_name"] . "</a></span>";
					
				$out .=  "<span class=\"top-fan-points\"><b>" . number_format( $user["points"] ) . "</b> " . wfMsg("top_fans_points") . "</span>";
				$out .= "<div class=\"cleared\"></div>";
				$out .= "</div>";
				$x++;
			}
			$out .= "</div><div class=\"cleared\"></div>";
			$wgOut->addHTML($out);
		}
			
		
	
	}

	SpecialPage::addPage( new TopFansRecent );

}

?>