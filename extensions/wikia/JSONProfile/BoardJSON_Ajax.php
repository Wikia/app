<?php

function user_name_display($id, $user_name) {
	
	$und = User::newFromId( $id );
	$und_full = $und->getRealName();
	$und_parts = split(" ", $und_full);
	$und_first = $und_parts[0];
	$und_last = $und_parts[1];
	
	$und_display = (($und_first&&$und_last)?ucwords(addslashes($und_first)." ".addslashes($und_last)):addslashes($user_name));
	
	return $und_display;
}

function process_messages_forJSON($messages, $r_user_name="") {
	
	foreach($messages as $message=>$message_stuff) {
					
		$message_stuff["board_to_board"] = "";
		$message_stuff["board_link"] = "";
		$message_stuff["send_text"] = "";
		$message_stuff["message_type_label"] = "";
		$message_stuff["delete_link"] = "";
		$message_stuff["user_from_link"] =  "profile.html?user={$message_stuff["user_name_from"]}";
		
		$p = new ProfilePhoto( $message_stuff["user_id_from"] );
		$message_stuff["avatar"] = $p->getPhotoImageTag("m");
		$message_stuff["avatar_img_s"] = $p->getProfileImageURL("s");
		
		$message_stuff["user_name_display"]=user_name_display($message_stuff["user_id_from"], $message_stuff["user_name_from"]);
		
		if($r_user_name!=$message_stuff["user_name_from"]){
			if ($message_stuff["user_name"] == $message_stuff["user_name_from"]) {
				$message_stuff["board_to_board"] = "board.html?user=".$message_stuff["user_name"] . "&conv=" . $message_stuff["user_name_from"];
			}else {
				$message_stuff["board_to_board"] = "board.html?user=".$r_user_name . "&conv=" . $message_stuff["user_name_from"] . (($message_stuff["type"] == 1)?"&type=".$message_stuff["type"]:"");
			}
			$message_stuff["board_link"] = "board.html?user=" . $message_stuff["user_name_from"] . (($message_stuff["type"] == 1)?"&type=".$message_stuff["type"]:"");
			$message_stuff["send_text"] = "Write on {$message_stuff["user_name_display"]}'s Wall";
		}
		if($r_user_name==$message_stuff["user_name"] || $r_user_name==$message_stuff["user_name_from"]){
			$message_stuff["delete_link"] = "javascript:delete_message({$message_stuff["id"]})";
		}
		if($message_stuff["type"] == 1){
			$message_stuff["message_type_label"] = "(private)";
		}
		
		$max_link_text_length = 50;
	
		$message_stuff["message_text"] = preg_replace_callback( "/(<a[^>]*>)(.*?)(<\/a>)/i",'cut_link_text',$message_stuff["message_text"]);
		$message_stuff["time_ago"] = get_time_ago($message_stuff["timestamp"]);
		$messages_full[] = $message_stuff;
	}
	return $messages_full;
}

$wgAjaxExportList [] = 'wfSendBoardMessageJSON';
function wfSendBoardMessageJSON(){ 
	global $IP, $wgMemc, $wgUser, $wgRequest;

	if($wgRequest->wasPosted()) {
		$user_name = $wgRequest->getVal("user_name");
		$message = $wgRequest->getVal("message");
		$message_type = $wgRequest->getVal("message_type");
		$count = $wgRequest->getVal("count");
		$wpSourceForm = $wgRequest->getVal("wpSourceForm");
		
		$user_name = stripslashes($user_name);
		$user_name = urldecode($user_name);
		$user_id_to = User::idFromName($user_name);
		$b = new UserBoard();
		
		$message = urldecode( $message );
		$message = str_replace( chr(10), "<br/>", $message );
		
		$m = $b->sendBoardMessage($wgUser->getID(),$wgUser->getName(),$user_id_to, $user_name, $message, $message_type);
		
		$key = wfMemcKey( 'user', 'profile', 'notifupdated', ($user_id_to ? $user_id_to : $user_name) );
		$wgMemc->set($key,false);
		
		$messages = $b->getUserBoardMessages($user_id_to,0,$count);
		$messages_full = array();
		$messages_full = process_messages_forJSON($messages, $wgUser->getName());
		
		$output = "<script type=\"text/javascript\">location.href='{$wpSourceForm}?posted=1';</script>";
		return $output;
	}else {
		return "// not posted";
	}
}

$wgAjaxExportList [] = 'getBoardMessagesJSON';
function getBoardMessagesJSON($user_name, $r_user_name="") {
	global $wgUserProfileDisplay, $wgUser, $IP;
	
	if ($wgUserProfileDisplay['board'] != false) {
		$board_JSON_array = doGetBoardMessagesJSON ($user_name, $r_user_name);
		$text =  "var json_board=" . jsonify($board_JSON_array) . ";\n\nboard_from_JSON(json_board);";
	}else{
		$text = "//board not enabled";
	}
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}
	
function doGetBoardMessagesJSON($user_name, $r_user_name="", $check_count=10, $from_notifications=false) {
	global $wgUserProfileDisplay, $wgUser, $IP;
	
	$user_id = User::idFromName($user_name);
	
	$p = new ProfilePrivacy();
	if( $user_id != $wgUser->getID() ){
		//SET UP PRIVACY
		$p->loadPrivacyForUser( $user_name );	
	}
	
	if ($wgUserProfileDisplay['board'] != false) {

		$profile_JSON_array = array();

		if( $user_id > 0 ){
			$user = User::newFromName($user_name);
			$user_name = $user->getName();
			$user_id = $user->getID();
		}
		
		if($r_user_name== "" && $wgUser->isLoggedIn()) {
			$r_user_name = $wgUser->getName();
		}
		
		if($r_user_name != "") {
			$r_user = User::newFromName($r_user_name);
			$r_user_name = $r_user->getName();
			$r_user_id = $r_user->getId();
			$r_logged_in = true;
		}
		else {
			$r_user_name = "";
			$r_user_id = "";
			$r_logged_in = false;
		}
			
		if( $user_id > 0 ){
			$stats = new UserStats($user_id, $user_name);
			$stats_data = $stats->getUserStats();
		}else{
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`user_board`', array( 'count(*) as the_count' ), array( 'ub_user_name' => $user_name ), __METHOD__ );
			$stats_data = array();
			$stats_data["user_board"] = $s->the_count;
		}
		
		if( !$p->getPrivacyCheckForUser("VIEW_WHITEBOARD") ){
			$stats_data["user_board"] = 0;
		}
		
		$rel = new UserRelationship($user_name);
		$friends = $rel->getRelationshipList(1,4);
		
		$user_safe = str_replace("&","%26",$user_name);
		$total = $stats_data["user_board"];
		if($r_user_name == $user_name)$total=$total+$stats_data["user_board_priv"];
		$right_action_link = "";
		$right_action_text = "";
		$right_action_link_2 = "";
		$right_action_text_2 = "";
		$slashed_user_name = "";
		
		$separator = wfMsg("user-count-separator");

		if($r_user_name == $user_name) {
			if($friends) {
				$right_action_link .= UserBoard::getBoardBlastURL();
				$right_action_text .= wfMsg("user-send-board-blast");
			}
		}
		 
		if($total>10) {
			$right_action_link_2 .= UserBoard::getUserBoardURL($user_name);
			$right_action_text_2 .= wfMsg("user-view-all");
		}
		
		$login_link = "";
		$login_text = "";
				
		if($r_user_name !== $user_name){

			if($r_user_name !== ""){
				$slashed_user_name .= addslashes($user_name);
			}else {
				$login_link = Title::makeTitle(NS_SPECIAL, "Login")->escapeFullURL();
				$login_text = wfMsg("user-board-login-message", $login_link);
			}
		}else {
			$slashed_user_name .= addslashes($user_name);
		}
		 
		$b = new UserBoard();
		if( $p->getPrivacyCheckForUser("VIEW_WHITEBOARD") ){
			if( $user_id > 0 ){
				$messages = $b->getUserBoardMessages($user_id,0,$check_count);
			}else{
				$messages = $b->getAnonUserBoardMessages($user_name,0,$check_count);
			}
		}else{
			$error = 1;
			$error_message = user_name_display($user_id, $user_name)."'s wall messages are private.";
			$messages = array();
		}
		
		$messages_full = array();		
		$messages_full = process_messages_forJSON($messages, $r_user_name);
		
		$is_owner = ($r_user_name != "" && ($r_user_name == $user_name));
		
		if ($from_notifications) {
			return $messages_full;
		}
		 
		$photo = new ProfilePhoto( $user_id  );
		
		$board_JSON_array = array(
			"title"=>wfMsg("user-board-title"),
			"avatar"=>$photo->getProfileImageURL("l"),
			"un_display"=>user_name_display($user_id, $user_name),
			"total"=>$total,
			"right_action_link"=>$right_action_link,
			"right_action_text"=>$right_action_text,
			"right_action_link_2"=>$right_action_link_2,
			"right_action_text_2"=>$right_action_text_2,
			"slashed_user_name"=>$slashed_user_name,
			"separator"=>$separator,
			"check_count"=>$check_count,
			"login_link"=>$login_link,
			"login_text"=>$login_text,
			"messages"=>$messages_full,
			"is_owner"=>$is_owner,
			"can_post"=>(( $p->getPrivacyCheckForUser("POST_WHITEBOARD") )?1:0),
			"error"=>$error,
			"error_message" =>$error_message
		);
		return $board_JSON_array;
	}
	return array();
}
	
$wgAjaxExportList [] = 'wfDeleteBoardMessageJSON';
function wfDeleteBoardMessageJSON($ub_id){ 
	global $IP, $wgMemc, $wgUser;
	
	$b = new UserBoard();
	if( $b->doesUserOwnMessage($wgUser->getID(),$ub_id) || $b->didUserSendMessage($wgUser->getID(),$ub_id) ){
		$b->deleteMessage($ub_id);
	}
	$text = "\$('profile-message-{$ub_id}').innerHTML=\"\";\n\n\$('profile-message-{$ub_id}').toggle();\n\nupdate_total();";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'getBoardtoBoardMessagesJSON';
function getBoardtoBoardMessagesJSON($user_name, $user_name_2, $page) {
	
	global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgStyleVersion, $wgUserBoardScripts;
	
	require_once( "$IP/extensions/wikia/UserBoard/UserBoard.i18n.php" );
	# Add messages
	global $wgMessageCache;
	foreach( $wgUserBoardMessages as $key => $value ) {
		$wgMessageCache->addMessages( $wgUserBoardMessages[$key], $key );
	}
	
	$messages_show = 25;
	$check_count = $messages_show;

	$page_title = "";
	$right_action_link = "";
	$right_action_text = "";
	$right_action_link_2 = "";
	$right_action_text_2 = "";
	$slashed_user_name = "";
	$board_to_board = "";
	$board_to_board_link = "";
	$board_to_board_messages = "";
	
	/*/
	/* If no user is set in the URL, we assume its the current user
	/*/	
	
	if(!$user_name)$user_name = $wgUser->getName();
	$user_id = User::idFromName($user_name);
	$user_safe = str_replace("&","%26",$user_name);
	
	if($user_name_2){
		$user_id_2 = User::idFromName($user_name_2);
		$user_safe_2 = urlencode($user_name_2);
	}
	
	/*/
	/* Config for the page
	/*/			
	$per_page = $messages_show;
	if(!$page || !is_numeric($page) )$page=1;
	
	$b = new UserBoard();
	$messages = $b->getUserBoardMessages($user_id,$user_id_2,$messages_show,$page);
	

	if(!$user_id_2){
		$stats = new UserStats($user_id, $user_name);
		$stats_data = $stats->getUserStats();
		$total = $stats_data["user_board"];
		if($wgUser->getName() == $user_name)$total=$total+$stats_data["user_board_priv"];
	}else{
		$total = $b->getUserBoardToBoardCount($user_id,$user_id_2);	
	}
	
	if(!$user_id_2){
		if (!($wgUser->getName() == $user_name)) {
			$page_title = wfMsg("userboard_owner", $user_name);
		} else {
			$b->clearNewMessageCount($wgUser->getID());
			$page_title = wfMsg("userboard_yourboard");
		}
	} else {
		$page_title = wfMsg("wall-to-wall", user_name_display($user_id, $user_name), user_name_display($user_id_2, $user_name_2));
	}
	
	if($page==1){
		$start = 1;
	}else{
		$start = ($page-1) * $per_page + 1;
	}
	$end = $start + ( count($messages) ) - 1;
	
	if($wgUser->getName()!=$user_name){
		$board_to_board = "board.html?user=" . $wgUser->getName() . "&conv=" . $user_name;
		
		$board_to_board_link = wfMsg( "userboard_boardtoboard" );
	}
	else {
		$slashed_user_name = $user_safe_2;
	}
	
	if( $total ){
		$board_to_board_messages = wfMsg( "userboard_showingmessages", $total, $start, $end );
	}
	
	/**/
	/*BUILD NEXT/PREV NAV
	**/
	if($user_id_2)$qs = "&conv={$user_safe_2}";
	$numofpages = $total / $per_page; 

	if($numofpages>1){
		$output .= "<div class=\"page-nav\">";
		if($page > 1){ 
			$output .= "<a href=\"\index.php?title=Special:UserBoard&user={$user_safe}&page=" . ($page-1) . "{$qs}\">" . wfMsg("userboard_prevpage") . "</a> ";
		}
		
		
		if(($total % $per_page) != 0)$numofpages++;
		if($numofpages >=9 && $page < $total){
			$numofpages=9+$page;
			if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
		}
		
		for($i = 1; $i <= $numofpages; $i++){
			if($i == $page){
			    $output .=($i." ");
			}else{
			    $output .="<a href=\"\index.php?title=Special:UserBoard&user={$user_safe}&page=$i{$qs}\">$i</a> ";
			}
		}

		if(($total - ($per_page * $page)) > 0){
			$output .=" <a href=\"\index.php?title=Special:UserBoard&user={$user_safe}&page=" . ($page+1) . "{$qs}\">" . wfMsg("userboard_nextpage") . "</a>"; 
		}
		$output .= "</div><p>";
	}
	
	$messages_full = array();
	$messages_full = process_messages_forJSON($messages, $r_user_name);
	
	$is_owner = ($r_user_name != "" && ($r_user_name == $user_name));
	
	$board_JSON_array = array(
		"title"=>$page_title,
		"board_to_board" => $board_to_board,
		"board_to_board_link" => $board_to_board_link,
		"board_to_board_messages" => $board_to_board_messages,
		"total"=>$total,
		"right_action_link"=>$right_action_link,
		"right_action_text"=>$right_action_text,
		"right_action_link_2"=>$right_action_link_2,
		"right_action_text_2"=>$right_action_text_2,
		"slashed_user_name"=>$slashed_user_name,
		"separator"=>$separator,
		"check_count"=>$check_count,
		"login_link"=>$login_link,
		"login_text"=>$login_text,
		"messages"=>$messages_full,
		"is_owner"=>$is_owner,
	);
	$text =  "var json_board=" . jsonify($board_JSON_array) . ";\n\nboard_from_JSON(json_board);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}
?>
