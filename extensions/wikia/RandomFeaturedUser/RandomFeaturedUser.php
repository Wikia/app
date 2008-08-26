<?php
$wgRandomFeaturedUser["avatar"] = true;
$wgRandomFeaturedUser["points"] = true;
$wgRandomFeaturedUser["about"] = true;

$wgExtensionFunctions[] = "wfRandomFeaturedUser";

function wfRandomFeaturedUser() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "randomfeatureduser", "GetRandomUser" );
}

function GetRandomUser( $input, $args, &$parser ){
	global $IP, $wgUser, $wgParser, $wgTitle, $wgOut, $wgMemc, $wgRandomFeaturedUser ;

	//wfProfileIn(__METHOD__);
	
	global $wgMessageCache, $IP;
	require_once ( "RandomFeaturedUser.i18n.php" );
	foreach( efWikiaRandomFeaturedUser() as $lang => $messages ){
		$wgMessageCache->addMessages( $messages, $lang );
	}
	
	$parser->disableCache();
	 
	$period = $args["period"];
	if( $period != "weekly" && $period != "monthly"){
		return "";
	}
	
	$user_list = array();
	$count = 10;	
	
	//try cache
	$key = wfMemcKey( 'user_stats', 'top', 'points', "weekly", $count );
	$data = $wgMemc->get( $key );
	
	if( $data != ""){
		wfDebug("Got top $period users by points ({$count}) from cache\n");
		$user_list = $data;
	
	}else{
		wfDebug("Got top $period users by points ({$count}) from db\n");
	
		$params['ORDER BY'] = 'up_points DESC';
		$params['LIMIT'] = $count;
		
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( 'user_points_' . $period, 
			array('up_user_id','up_user_name','up_points'), 
			array('up_user_id <> 0'), __METHOD__, 
			$params
		);
		while( $row = $dbr->fetchObject($res) ){
			//prevent blocked users from appearing
			$user = User::newFromId($row->up_user_id);
			$user->loadFromDatabase();
			
			$user_list[] = array(  
						"user_id" => $row->up_user_id,
						"user_name" => $row->up_user_name,
						"points" => $row->up_points
						);
			
		}
		if( count($user_list) > 0 ){
			$wgMemc->set( $key, $user_list, 60 * 60);
		}
	}
	
	//make sure we have some data
	if( !is_array( $user_list ) || count( $user_list ) == 0){
		return "";
	}
	
	$random_user = $user_list[ array_rand( $user_list, 1) ];

	//make sure we have a user
	if( !$random_user["user_id"] ){
		return "";
	}
	
	$output .= "<div class=\"random-featured-user\">";
	
	if( $wgRandomFeaturedUser["points"] == true ){
		$stats = new UserStats($random_user["user_id"], $random_user["user_name"]);
		$stats_data = $stats->getUserStats();
		$points = $stats_data["points"];
	}
	
	if( $wgRandomFeaturedUser["avatar"] == true ){
		$user_title = Title::makeTitle( NS_USER  , $random_user["user_name"]  );
		$avatar = new wAvatar( $random_user["user_id"] ,"ml");
		$avatar_image = $avatar->getAvatarURL();
		
		$output .= "<a href=\"{$user_title->escapeFullURL()}\">{$avatar_image}</a>\n";
	}
	
	$output .= "<div class=\"random-featured-user-title\"><a href=\"{$user_title->escapeFullURL()}\">".wordwrap($random_user["user_name"], 12, "<br/>\n", true)."</a><br/> $points " . wfMsg("random_user_points_{$period}") . "</div>\n\n";
	
	if( $wgRandomFeaturedUser["about"] == true ){
		$p = new Parser();
		$profile = new UserProfile( $random_user["user_name"] );
		$profile_data = $profile->getProfile();
		$about = $profile_data["about"];
		//remove templates
		$about =  preg_replace('@{{.*?}}@si', '', $about);
		if($profile_data["about"])$output .= "<div class=\"random-featured-user-about-title\">" .wfMsg("random_user_about_me") . "</div>" . $p->parse( $about, $wgTitle, $wgOut->parserOptions(), false)->getText();
	}
	
	$output .= "</div><div class=\"cleared\"></div>";
	
	wfProfileOut(__METHOD__);
	
	return $output;
}

?>