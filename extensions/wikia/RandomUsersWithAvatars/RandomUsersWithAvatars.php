<?php
/**
 * @todo Has an updated fork in MediaWiki svn under the same name that is
 *       supported by translatewiki.net. Might be able to retire this instance
 *       with little effort.
 */

$wgExtensionFunctions[] = "wfRandomUsersWithAvatars";

function wfRandomUsersWithAvatars() {
    global $wgParser, $wgOut, $wgExtensionMessagesFiles;
    $wgParser->setHook( "randomuserswithavatars", "GetRandomUsersWithAvatars" );
	$wgExtensionMessagesFiles['randomuserswithavatars'] = dirname( __FILE__ ) . '/RandomUsersWithAvatars.i18n.php';
}

function GetRandomUsersWithAvatars( $input, $args, &$parser ){
	global $wgUser, $wgParser, $wgTitle, $wgOut, $wgUploadDirectory, $wgDBname, $wgMemc;

	wfProfileIn(__METHOD__);
	
	$parser->disableCache();

	$count = ( isset($args["count"]) && is_numeric($args["count"]) ) ? $args["count"] : 10;
	$per_row = ( isset($args["row"]) && is_numeric($args["row"]) ) ? $args["row"] : 4;
	
	//try cache
	$key = wfMemcKey( 'users', 'random', 'avatars', $count, $per_row );
	$data = $wgMemc->get( $key );
	if( !$data ){
		$files = glob($wgUploadDirectory . "/avatars/{$wgDBname}_*_ml.*");
		$wgMemc->set( $key, $files, 60 * 60);
	}else{
		wfDebug("Got random users with avatars from cache\n");
		$files = $data;
	}

	$user_array = array();
	$random_users = array();

	wfLoadExtensionMessages('randomuserswithavatars');

	$output = "<div class=\"random-users-avatars\">
		<h2>".wfMsg("random-users-avatars-title")."</h2>";

	$x=1;
	
	if( count( $files ) < $count)$count = count($files);
	if( $count > 0 ) {
		$random_keys = array_rand($files, $count);
	} else {
		$random_keys = array();
	}
	
	foreach ($random_keys as $random) {
		
		//extract userid out of avatar image name
		$avatar_name = basename( $files[$random] );
		preg_match("/{$wgDBname}_(.*)_/i", $avatar_name, $matches);
		$user_id = $matches[1];
		
		if( $user_id ){
			//load user
			$user = User::newFromId( $user_id );
			$user->loadFromDatabase();
			$user_name = $user->getName();	
			
			$avatar = new wAvatar($user_id,"ml");
			$user_link = Title::makeTitle(NS_USER, $user_name);
			
			$output .= "<a href=\"".$user_link->escapeFullURL()."\" rel=\"nofollow\">{$avatar->getAvatarURL()}</a>";
			
			if($x==$count || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
			$x++;
			
		}
	}
	
	$output .= "<div class=\"cleared\"></div>
	</div>";
	
	wfProfileIn(__METHOD__);
	
	return $output;
}
