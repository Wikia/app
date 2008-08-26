<?php
$wgExtensionFunctions[] = "wfSiteActivity";

function wfSiteActivity() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "siteactivity", "GetSiteActivity" );
}

function GetSiteActivity( $input, $args, &$parser ){
	global $wgUser, $wgParser, $wgTitle, $wgOut, $wgMemc,$IP, $wgUploadPath, $wgMessageCache;

	$parser->disableCache();
	 
	$limit = $args["limit"];
	if(!$limit)$limit = 10;
	
	require_once ( "$IP/extensions/wikia/UserHome/UserActivity.i18n.php" );
	foreach( efWikiaUserActivity() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}

	require_once("$IP/extensions/wikia/UserActivity/UserActivityClass.php");
	
	$key = wfMemcKey( 'site_activity', 'all', $limit );
	$data = $wgMemc->get( $key );
	if( !$data ){
		wfDebug("Got site activity from db\n");
		$rel = new UserActivity("","ALL",$limit);
		
		$rel->setActivityToggle("show_votes",0);
		$rel->setActivityToggle("show_network_updates",0);
		$activity = $rel->getActivityListGrouped();
		$wgMemc->set( $key, $activity, 60 * 2);
	}else{
		wfDebug("Got site activity from cache\n");
		$activity = $data;
	}
 
	$output = '';
	if($activity) {
		
		$output .= "<div class=\"mp-site-activity\"><h2>" . $wgParser->recursiveTagParse( wfMsg("site_activity_title") ) . "</h2>";
		
		$x = 1;
		foreach ($activity as $item) {
			if( $x < $limit ) {
				$output .= "<div class=\"mp-activity " . (($x==$limit)?"mp-activity-boarder-fix":"") . "\"><img src=\"{$wgUploadPath}/common/" . UserActivity::getTypeIcon($item["type"]) . "\" alt=\""  . UserActivity::getTypeIcon($item["type"]) . "\" border='0' />{$item["data"]}</div>";
				$x++;
			}
		}
		
		$output .= "</div>";
	}
	
	return $output;
	
}

?>
