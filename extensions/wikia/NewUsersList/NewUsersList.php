<?php
$wgExtensionFunctions[] = "wfGetNewUsers";

function wfGetNewUsers() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "newusers", "GetNewUsers" );
}

function GetNewUsers( $input, $args, &$parser ) {
	global $wgUser, $wgParser, $wgTitle, $wgOut, $wgUploadDirectory, $wgMemc;
	$parser->disableCache();
	$count = (isset($args["count"]) && is_numeric($args["count"])) ? intval($args["count"]) : 10;
	$per_row = (isset($args["row"]) && is_numeric($args["row"])) ? intval($args["row"]) : 5;
	//try cache
	$key = wfMemcKey( 'users', 'new', $count );
	$data = $wgMemc->get( $key );
		
	if ( !$data ) {
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( 
			"`user_register_track`", 
			array('ur_user_id','ur_user_name'), 
			null, 
			__METHOD__, 
			array('ORDER BY' => 'ur_date', 'LIMIT' => $count)
		);
		$list = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			$list[] = array(
				"user_id" => $row->ur_user_id,
				"user_name" => $row->ur_user_name
			);
		}
		$wgMemc->set( $key, $list, 60 * 10 );
	} else {
		wfDebug( "Got new users from cache\n" );
		$list = $data;
	}
	
	$output = "<div class=\"new-users\">";

	$x=1;
	foreach ($list as $user) {
		$avatar = new wAvatar( $user["user_id"] ,"ml" );
		$user_link = Title::makeTitle(NS_USER, $user["user_name"] );
		
		$output .= "<a href=\"".$user_link->escapeFullURL()."\" rel=\"nofollow\">{$avatar->getAvatarURL()}</a>";
		
		if ( ($x == $count) || ($x != 1) && ($x % $per_row == 0) ) {
			$output .= "<div class=\"cleared\"></div>";
		}
		$x++;
	}
	
	$output .= "<div class=\"cleared\"></div>
	</div>";
	
	return $output;
}
