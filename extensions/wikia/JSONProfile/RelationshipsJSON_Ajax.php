<?php

$wgAjaxExportList [] = 'wfGetRelationshipsJSON';
function wfGetRelationshipsJSON($user_name="", $rel_type=1, $page=1, $callback="showRelationships", $trust_type = -1 ){
	global $wgUser, $wgOut, $wgRequest, $IP, $wgMessageCache;
	
	$rel_JSON_array = array();
	$rel_JSON_array["r_user_name"] = "";
	
	if ($wgUser->isLoggedIn()) {
		$rel_JSON_array["r_user_name"] = $wgUser->getName();
	}
	
	$rel_JSON_array["error"] = 0;
	$rel_JSON_array["status_message"] = "";
				
	if($wgUser->getID() == 0 && $user_name==""){
		$rel_JSON_array["rel"] = array();
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = "You can't view your friends if you aren't logged in! 
						    Click <a href=\"login.html\">here</a> to login
						    or click <a href=\"register.html\">here</a> to register.";
		
		$text =  "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}
	
	/*/
	/* Set up config for page / default values
	/*/	
	if(!$page || !is_numeric($page) )$page=1;
	if(!$rel_type || !is_numeric($rel_type) )$rel_type = 1;
	$per_page = 10;
	$per_row = 2;
	
	$rel_JSON_array["per_page"] = $per_page;
	$rel_JSON_array["per_row"] = $per_row;
	
	/*/
	/* If no user is set in the URL, we assume its the current user
	/*/		
	if(!$user_name)$user_name = $wgUser->getName();
	$user_id = User::idFromName($user_name);
	$user = Title::makeTitle(NS_USER, $user_name);
	
	$rel_JSON_array["user_name"] = $user_name;
	$rel_JSON_array["rel_type"] = $rel_type;
	$rel_JSON_array["page"] = $page;

	
	/*/
	/* Error message for username that does not exist (from URL)
	/*/			
	if($user_id == 0){
		
		$rel_JSON_array["rel"] = array();
		$rel_JSON_array["error"] = 2;
		$rel_JSON_array["status_message"] = wfMsg("ur-error-message-no-user");
		$text =  "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}	
	
	/*
	Get all relationships
	*/
	
	$rel = new UserRelationship($user_name);
	$awaiting_requests = array();
	$p = new ProfilePrivacy();
	if( $rel->user_id != $wgUser->getID() ){
		//SET UP PRIVACY
		$p->loadPrivacyForUser( $user_name );
		$this_rel = new UserRelationship($wgUser->getName());
		$awaiting_requests = $this_rel->getAwaitingRequests();
	}
	
	if( $p->getPrivacyCheckForUser("VIEW_FULL") && $p->getPrivacyCheckForUser("VIEW_FRIENDS") ){
		$relationships = $rel->getRelationshipList($rel_type, $per_page, $page, $trust_type);
	}else{
		$relationships = array();
		$rel_JSON_array["error"] = 101;
		$rel_JSON_array["status_message"] = user_name_display($rel->user_id, $user_name)."'s friend list is private";
	}
	
	$stats = new UserStats($rel->user_id, $rel->user_name);
	$stats_data = $stats->getUserStats();
	
	if( $trust_type > 0 ){
		$friend_count = $rel->getRelationshipCount( 1, $trust_type );
		$foe_count = $rel->getRelationshipCount( 2, $trust_type );
	}else{
		$friend_count = $stats_data["friend_count"];
		$foe_count = $stats_data["foe_count"];
	}
	
	$un_display = user_name_display($rel->user_id, $rel->user_name);

	$rp = new ProfilePhoto( $rel->user_id );
	$rel_JSON_array["r_avatar"] = $rp->getProfileImageURL("l"); 
	
	if ($rel_type==1) {
	    $rel_JSON_array["page_title"] = "{$un_display}'s Friend List";
	    $rel_JSON_array["count"] = $friend_count;
	    $rel_JSON_array["label"] = wfMsg('ur-friend');
	} else {
	    $rel_JSON_array["page_title"] = "{$un_display}'s Foe List";
	    $rel_JSON_array["count"] = $foe_count;
	    $rel_JSON_array["label"] = wfMsg('ur-foe');
	}
	
	$rel_JSON_array["back_link_text"] = wfMsg('ur-backlink',$un_display);
	$rel_JSON_array["back_link"] = "profile.html?user=".$rel->user_name;
	$back_link = Title::makeTitle(NS_USER,$rel->user_name);

	$rel_full = array();
	
	if ($relationships) {
		
		$x = 1;
		
		$rel_JSON_array["add_friend_text"] = wfMsg("ur-add-friend");
		$rel_JSON_array["add_foe_text"] = wfMsg("ur-add-foe");
		$rel_JSON_array["give_gift_text"] = wfMsg("ur-give-gift");
		$rel_JSON_array["remove_rel_text"] = wfMsg("ur-remove-relationship", ucfirst($rel_JSON_array["label"]));
		$rel_JSON_array["edit_rel_text"] = wfMsg("ur-edit-relationship", ucfirst($rel_JSON_array["label"]));
		foreach ($relationships as $relationship) {
			
			$indivRelationship = UserRelationship::getUserRelationshipByID($relationship["user_id"],$wgUser->getID());
		
			$relationship["awaiting_request"] = in_array( $relationship["user_id"], $awaiting_requests );
				
			//safetitles
			$user =  Title::makeTitle(NS_USER, $relationship["user_name"]);
			$add_relationship_link = Title::makeTitle(NS_SPECIAL,"AddRelationship");
			$remove_relationship_link = Title::makeTitle(NS_SPECIAL,"RemoveRelationship");
			$give_gift_link = Title::makeTitle(NS_SPECIAL, "GiveGift");
			
			$p = new ProfilePhoto( $relationship["user_id"] );
			$pr = new ProfilePrivacy();
			$pr->loadPrivacyForUser( $relationship["user_name"] );
			$user_privacy = array();
			$user_privacy["POST_WHITEBOARD"] = (( $pr->getPrivacyCheckForUser("POST_WHITEBOARD") )?1:0);
			$user_privacy["POKE"] = (( $pr->getPrivacyCheckForUser("POKE") )?1:0);
			$user_safe = urlencode($relationship["user_name"]);
			
			
			$relationship["pokes"] = wfOutstandingPokesJSON($relationship["user_name"], $wgUser->getName());
			
			$relationship["user_safe"] = $user_safe;
			
			//full name
			$n = User::newFromId( $relationship["user_id"] );
			$n_full = $n->getRealName();
			$n_parts = split(" ", $n_full);
			$n_first = $n_parts[0];
			$n_last = $n_parts[1];
			
			$relationship["first_name"] = ucfirst($n_first);
			$relationship["last_name"] = ucfirst($n_last);
			
			$username_length = strlen($relationship["user_name"]);
			$username_space = stripos($relationship["user_name"], ' ');
			
			if (($username_space == false || $username_space >= "30") && $username_length > 30){
				$user_name_display = substr($relationship["user_name"], 0, 30)." ".substr($relationship["user_name"], 30, 50);
			}
			else {
				$user_name_display = $relationship["user_name"];
			};
			
			$relationship["user_name_display"] = $user_name_display;
			$relationship["avatar"] = $p->getPhotoImageTag("m");
			$relationship["indiv_relationship"] = $indivRelationship;
			$relationship["latest_status"] = UserStatus::getLatestMessage( $relationship["user_id"] ) ;
			$relationship["privacy"] = $user_privacy;
			
			$rel_full[] = $relationship;
		}
	}
	$rel_JSON_array["rel"] = $rel_full;
	
	$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;

}

$wgAjaxExportList [] = 'wfGetMutualRelationshipsJSON';
function wfGetMutualRelationshipsJSON($user_name="", $rel_type=1, $page=1, $callback="showRelationships"  ){
	
	global $wgUser, $wgOut, $wgRequest, $IP, $wgMessageCache;

			
	$rel_JSON_array = array();
	$rel_JSON_array["r_user_name"] = "";
	
	if ($wgUser->isLoggedIn()) {
		$rel_JSON_array["r_user_name"] = $wgUser->getName();
	}
	
	$rel_JSON_array["error"] = 0;
	$rel_JSON_array["status_message"] = "";
				
	if($wgUser->getID() == 0 && $user_name==""){
		$rel_JSON_array["rel"] = array();
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = "You must login and specific a user to see this page.";
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}
	
	/*/
	/* Set up config for page / default values
	/*/	
	if(!$page || !is_numeric($page) )$page=1;
	if(!$rel_type || !is_numeric($rel_type) )$rel_type = 1;
	$per_page = 12;
	$per_row = 2;
	
	$rel_JSON_array["per_page"] = $per_page;
	$rel_JSON_array["per_row"] = $per_row;
	

	$user_id = User::idFromName($user_name);
	$user = Title::makeTitle(NS_USER, $user_name);
	
	$rel_JSON_array["user_name"] = $user_name;
	$rel_JSON_array["rel_type"] = $rel_type;
	$rel_JSON_array["page"] = $page;

	
	/*/
	/* Error message for username that does not exist (from URL)
	/*/			
	if($user_id == 0){
		
		$rel_JSON_array["rel"] = array();
		$rel_JSON_array["error"] = 2;
		$rel_JSON_array["status_message"] = wfMsg("ur-error-message-no-user");
		return "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	}	
	
	/*
	Build Mutual Friends List
	*/
	
	//The user you are viewing
	$rel = new UserRelationship($user_name);
	$complete_friends = $rel->getAllRelationships();
	
	//your friend list
	$rel_current_user = new UserRelationship( $wgUser->getName() );
	
	$p = new ProfilePrivacy();
	if( $rel->user_id != $wgUser->getID() ){
		//SET UP PRIVACY
		$p->loadPrivacyForUser( $user_name );	
	}
	
	if( $p->getPrivacyCheckForUser("VIEW_FULL") && $p->getPrivacyCheckForUser("VIEW_FRIENDS") ){
		$complete_friends_current_user = $rel_current_user->getAllRelationships();
	}else{
		$complete_friends_current_user = array();
		$rel_JSON_array["error"] = 101;
		$rel_JSON_array["status_message"] = user_name_display($rel->user_id, $user_name)."'s mutual friend list is private";
	}
		
	//combined array
	$mutual_friends = array_intersect_key($complete_friends_current_user, $complete_friends);
	$total_count = count( $mutual_friends );
	
	//get the proper page
	if($page)$offset = $page * $per_page - ($per_page); 
	$mutual_friends = array_slice($mutual_friends, $offset, $per_page, true);
	
	$un_display = user_name_display($rel->user_id, $rel->user_name);
	
	$rp = new ProfilePhoto( $rel->user_id );
	$rel_JSON_array["r_avatar"] = $rp->getProfileImageURL("l");
	
	if ($rel_type==1) {
	    $rel_JSON_array["page_title"] = "Mutual Friends with {$un_display}";
	    $rel_JSON_array["count"] = $total_count . "";
	    $rel_JSON_array["label"] = wfMsg('ur-friend');
	} 
	
	$rel_JSON_array["back_link_text"] = wfMsg('ur-backlink',$un_display);
	$rel_JSON_array["back_link"] = "profile.html?user=".$rel->user_name;
	$back_link = Title::makeTitle(NS_USER,$rel->user_name);

	$rel_full = array();
	
	if ($mutual_friends) {
		
		$x = 1;
		
		$rel_JSON_array["remove_rel_text"] = wfMsg("ur-remove-relationship", ucfirst($rel_JSON_array["label"]));
		$rel_JSON_array["edit_rel_text"] = wfMsg("ur-edit-relationship", ucfirst($rel_JSON_array["label"]));
		foreach ($mutual_friends as $relationship) {
			
			//safetitles
			$user =  Title::makeTitle(NS_USER, $relationship["user_name"]);
			//full name
			$n = User::newFromId( $relationship["user_id"] );
			$n_full = $n->getRealName();
			$n_parts = split(" ", $n_full);
			$n_first = $n_parts[0];
			$n_last = $n_parts[1];
			
			$relationship["first_name"] = ucfirst($n_first);
			$relationship["last_name"] = ucfirst($n_last);
		
			$p = new ProfilePhoto( $relationship["user_id"] );
			$pr = new ProfilePrivacy();
			$pr->loadPrivacyForUser( $relationship["user_name"] );
			$user_privacy = array();
			$user_privacy["POST_WHITEBOARD"] = (( $pr->getPrivacyCheckForUser("POST_WHITEBOARD") )?1:0);
			$user_privacy["POKE"] = (( $pr->getPrivacyCheckForUser("POKE") )?1:0);
			$user_safe = urlencode($relationship["user_name"]);
			
			$relationship["pokes"] = wfOutstandingPokesJSON($relationship["user_name"], $wgUser->getName());
			
			$user_safe = urlencode($relationship["user_name"]);	
			$relationship["user_safe"] = $user_safe;
			
			$username_length = strlen($relationship["user_name"]);
			$username_space = stripos($relationship["user_name"], ' ');
			
			if (($username_space == false || $username_space >= "30") && $username_length > 30){
				$user_name_display = substr($relationship["user_name"], 0, 30)." ".substr($relationship["user_name"], 30, 50);
			}
			else {
				$user_name_display = $relationship["user_name"];
			};
			
			$relationship["user_name_display"] = $user_name_display;
			$relationship["avatar"] = $p->getPhotoImageTag("m");
			$relationship["indiv_relationship"] = $indivRelationship;
			$relationship["latest_status"] = UserStatus::getLatestMessage( $relationship["user_id"] ) ;
			$relationship["privacy"] = $user_privacy;
			
			$rel_full[] = $relationship;
		}
	}
	$rel_JSON_array["rel"] = $rel_full;
	$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'wfCheckAddRelationshipJSON';
function wfCheckAddRelationshipJSON($user_name="", $rel_type=1, $callback="handleAddRel"){
	
	global $wgUser, $wgOut, $wgRequest, $wgMessageCache, $IP, $wgUploadPath;
	
	$rel_JSON_array = array();
	
	$rel_JSON_array["r_user_name"] = "";
	$rel_JSON_array["avatar_img"] = "";
	$rel_JSON_array["has_redirect"] = false;
	$rel_JSON_array["redirect_to"] = "";
	$rel_JSON_array["error"] = 0;
	$rel_JSON_array["status_message"] = "";
	$rel_JSON_array["page_title"] = "";
	$rel_JSON_array["button_1_text"] = wfMsg("ur-main-page");
	$rel_JSON_array["button_1_link"] = "";
	$rel_JSON_array["button_2_text"] = wfMsg("ur-your-profile");
	$rel_JSON_array["button_2_link"] = "window.location='profile.html?user=".$wgUser->getName()."';";
	
	if ($wgUser->isLoggedIn()) {
		$rel_JSON_array["r_user_name"] = $wgUser->getName();
	}else {
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = "You must be login to friend another user.";
		$rel_JSON_array["page_title"] = "Please Log In";
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}
	
	if ($user_name == "") {
		$rel_JSON_array["error"] = 2;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-no-user");
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}
	
	$usertitle = Title::newFromDBkey($user_name);
	$user =  Title::makeTitle( NS_USER  , $usertitle->getText()  );
	  
	if(!$usertitle){
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = "You must specify a user to friend.";
		$rel_JSON_array["page_title"] = "Please Specify a User";
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}
	
	$user_name_to = $usertitle->getText();
	$user_id_to = User::idFromName($user_name_to);
	$relationship_type = $rel_type;
	
	if(!$relationship_type || !is_numeric($relationship_type) )$relationship_type = 1;

	$rel_JSON_array["user_name"] = $user_name_to;
	$rel_JSON_array["user_name_display"] = user_name_display($user_id_to, $user_name_to);
	$rel_JSON_array["user_id"] = $user_id_to;
	$rel_JSON_array["rel_type"] = $relationship_type;

	
	if (($wgUser->getID()== $user_id_to) && ($wgUser->getID() != 0)) {
		$rel_JSON_array["error"] = 2;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-yourself");
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		
	} else if ($wgUser->isBlocked()) {
		$rel_JSON_array["error"] = 2;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-blocked");
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	
	} else if ($user_id_to == 0) {
		$rel_JSON_array["error"] = 2;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-no-user");
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		
	} else if(UserRelationship::getUserRelationshipByID($user_id_to,$wgUser->getID())>=1){
		
		if (UserRelationship::getUserRelationshipByID($user_id_to,$wgUser->getID())==1) {
			$label = wfMsg("ur-friend");
		} else {
			$label = wfMsg("ur-foe");
		}
		
		$p = new ProfilePhoto( $user_id_to );

		$rel_JSON_array["error"] = 3;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-existing-relationship", $label, user_name_display($user_id_to, $user_name_to));
		$rel_JSON_array["page_title"] = wfMsg("ur-add-error-message-existing-relationship", $label, user_name_display($user_id_to, $user_name_to));
		$rel_JSON_array["avatar_img"] = $p->getPhotoImageTag("l");
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		
	} else if (UserRelationship::userHasRequestByID($user_id_to,$wgUser->getID()) == true){
		
		if ($relationship_type==1) {
			$label = wfMsg("ur-friend");
		} else {
			$label = wfMsg("ur-foe");
		}
		
		$p = new ProfilePhoto( $user_id_to );
		
		$rel_JSON_array["error"] = 3;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-pending-request", $label, user_name_display($user_id_to, $user_name_to));
		$rel_JSON_array["page_title"] = wfMsg("ur-add-error-message-pending-request-title");
		$rel_JSON_array["avatar_img"] = $p->getPhotoImageTag("l");
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		
	} else if (UserRelationship::userHasRequestByID($wgUser->getID(),$user_id_to) == true) {
		$rel_JSON_array["error"] = 4;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-pending-request", $label, user_name_display($user_id_to, $user_name_to));
		$rel_JSON_array["page_title"] = "Pending Request";
		$rel_JSON_array["has_redirect"] = true;
		$rel_JSON_array["redirect_to"] = "relrequests.html";
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	
	} else if ($wgUser->getID() == 0){
		if ($this->relationship_type==1) {
			$label = wfMsg("ur-friend");
		} else {
			$label = wfMsg("ur-foe");
		}
		
		$rel_JSON_array["error"] = 3;
		$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-not-loggedin", $label);
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$rel_JSON_array["button_2_text"] = wfMsg("ur-login");
		$rel_JSON_array["button_2_link"] = "window.location='login.html';";
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	}
	else {
		$_SESSION["alreadysubmitted"] = false;
		if ($relationship_type==1) {
			$label = wfMsg('ur-friend');
			$label1 = wfMsg('ur-friendship');
		} else {
			$label = wfMsg('ur-foe');
			$label1 = wfMsg('ur-grudge');
		}
		$p = new ProfilePhoto( $user_id_to );
		
		$rel_JSON_array["type"] = $label;
		$rel_JSON_array["avatar_img"] = $p->getPhotoImageTag("l");
		$rel_JSON_array["page_title"] = wfMsg("ur-add-title", user_name_display($user_id_to, $user_name_to), $label);
		$rel_JSON_array["status_message"] = wfMsg("ur-add-message", user_name_display($user_id_to, $user_name_to), $label, $label1);
		$rel_JSON_array["button_1_text"] = wfMsg('ur-add-button', ucfirst($label));
		$rel_JSON_array["button_1_link"] = "submit_rel_request();";
		$rel_JSON_array["button_2_text"] = wfMsg('ur-cancel');
		$rel_JSON_array["button_2_link"] = "history.go(-1);";
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	}
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}


$wgAjaxExportList [] = 'wfAddRelationshipJSON';
function wfAddRelationshipJSON(){

	global $wgUser, $wgRequest, $IP, $wgMemc;
	
	if ($wgUser->isLoggedIn()) {

		$rel = new UserRelationship($wgUser->getName() );
		
		if ($wgRequest->wasPosted() ) {
			
			$user_name_to = $wgRequest->getVal("user_name");
			$relationship_type = $wgRequest->getVal("rel_type");
			$message = urldecode($wgRequest->getVal("message"));
			$wpSourceForm = $wgRequest->getVal("wpSourceForm");
			$trust_type = $wgRequest->getVal("rel_trust_type");
			
			if ($relationship_type == "") $relationship_type=1;
			
			if ($user_name_to != "" && $relationship_type != "" && $wpSourceForm != "") {
				
				$rel = $rel->addRelationshipRequest($user_name_to,$relationship_type,$message,true,$trust_type);
				$user_id_to = User::idFromName($user_name_to);
				$key = wfMemcKey( 'user', 'profile', 'notifupdated', $user_id_to );
				$wgMemc->set($key,false);
				
				$output = "<script type=\"text/javascript\">location.href='{$wpSourceForm}?success=1';</script>";
			}
			else {
				$output = "<script type=\"text/javascript\">alert('Something wasnt set properly');\n\nlocation.href='{$wpSourceForm}';</script>";
			}
		}
		else {
			$output = "<script type=\"text/javascript\">alert('This was already submitted or was not posted');\n\nlocation.href='{$wpSourceForm}';</script>";
		}
	}
	else {
		$output = "<script type=\"text/javascript\">alert('You are not logged in');\n\nlocation.href='{$wpSourceForm}';</script>";
	}
	
	return $output;
}

$wgAjaxExportList [] = 'wfCheckRemoveRelationshipJSON';
function wfCheckRemoveRelationshipJSON($user_name, $callback="handleRemRel"){
	
	global $wgUser, $wgOut, $wgRequest, $IP, $wgMessageCache, $wgUploadPath;
	
	$usertitle = Title::newFromDBkey($user_name);
	if(!$usertitle){
		$wgOut->addHTML("No user selected.  Please remove friends/foes through the correct link.");
		return false;	
	}
	
	$user_name_to = $usertitle->getText();
	$user_id_to = User::idFromName($user_name_to);
	$relationship_type = UserRelationship::getUserRelationshipByID($user_id_to,$wgUser->getID());
	
	$rel_JSON_array["r_user_name"] = "";
	$rel_JSON_array["avatar_img"] = "";
	$rel_JSON_array["has_redirect"] = false;
	$rel_JSON_array["redirect_to"] = "";
	$rel_JSON_array["error"] = 0;
	$rel_JSON_array["status_message"] = "";
	$rel_JSON_array["page_title"] = "";
	$rel_JSON_array["button_1_text"] = wfMsg("ur-main-page");
	$rel_JSON_array["button_1_link"] = "";
	$rel_JSON_array["button_2_text"] = wfMsg("ur-your-profile");
	$rel_JSON_array["button_2_link"] = "window.location='profile.html?user=".$wgUser->getName()."';";

	$rel_JSON_array["user_name"] = $user_name_to;
	$rel_JSON_array["rel_type"] = $relationship_type;

	
	$label = wfMsg("ur-friend");
	
	$rel_JSON_array["type"] = $label;

	if ($wgUser->getID() == 0) {
		
		$rel_JSON_array["error"] = 4;
		$rel_JSON_array["status_message"] = wfMsg("ur-remove-error-not-loggedin", $label);
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	} 
	
	if($wgUser->getID()== $user_id_to){
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = wfMsg("ur-remove-error-message-remove-yourself");
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;	
		
	} else if ($relationship_type==false) {
		$rel_JSON_array["error"] = 2;
		$rel_JSON_array["status_message"] = wfMsg("ur-remove-error-message-no-relationship", user_name_display($user_id_to, $user_name_to));
		$rel_JSON_array["page_title"] = wfMsg("ur-remove-error-message-title-no-relationship");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
		
	} else if (UserRelationship::userHasRequestByID($user_id_to,$wgUser->getID()) == true) {
		$rel_JSON_array["error"] = 3;
		$rel_JSON_array["status_message"] = wfMsg("ur-remove-error-message-pending-request", $label, user_name_display($user_id_to, $user_name_to));
		$rel_JSON_array["page_title"] = wfMsg("ur-error-title");
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;	
		
	} else {
		$_SESSION["alreadysubmitted"] = false;
		$p = new ProfilePhoto( $user_id_to );
	  
		$rel_JSON_array["avatar_img"] = $p->getPhotoImageTag("l");
		
		$rel_JSON_array["page_title"] = wfMsg("ur-remove-relationship-title", user_name_display($user_id_to, $user_name_to), $label);
		$rel_JSON_array["status_message"] =wfMsg("ur-remove-relationship-message", user_name_display($user_id_to, $user_name_to), $label, wfMsg("ur-remove"));
		
		$rel_JSON_array["button_1_text"] = wfMsg("ur-remove");
		$rel_JSON_array["button_1_link"] = "submit_rel_remove();";
		$rel_JSON_array["button_2_text"] = wfMsg("ur-cancel");
		$rel_JSON_array["button_2_link"] = "history.go(-1);";
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}

}

$wgAjaxExportList [] = 'wfRemoveRelationshipJSON';
function wfRemoveRelationshipJSON($user_name, $callback="handle_removed"){

	global $wgUser, $wgRequest, $IP, $wgMessageCache;
	if ($wgUser->isLoggedIn()) {
		
		$usertitle = Title::newFromDBkey($user_name);
		if(!$usertitle){
			$wgOut->addHTML("No user selected.  Please remove friends/foes through the correct link.");
			return false;	
		}
		
		$user_name_to = $usertitle->getText();
		$user_id_to = User::idFromName($user_name_to);
		
		$relationship_type = UserRelationship::getUserRelationshipByID($user_id_to,$wgUser->getID());
		$rel = new UserRelationship($wgUser->getName() );
		if($relationship_type){
			if($relationship_type==1){
			   $label = wfMsg("ur-friend");
			} else {
			   $label = wfMsg("ur-foe");
			}
			
			$_SESSION["alreadysubmitted"] = true;
						
			$rel->removeRelationshipByUserID($user_id_to,$wgUser->getID() );
			$rel->sendRelationshipRemoveEmail($user_id_to, $wgUser->getName(), $relationship_type);
			
			$p = new ProfilePhoto( $user_id_to );
			
			$rel_JSON_array["r_user_name"] = "";
			$rel_JSON_array["avatar_img"] = $p->getPhotoImageTag("l");
			$rel_JSON_array["has_redirect"] = false;
			$rel_JSON_array["redirect_to"] = "";
			$rel_JSON_array["error"] = 0;
			$rel_JSON_array["status_message"] = wfMsg("ur-remove-relationship-message-confirm", user_name_display($user_id_to, $user_name_to), $label);
			$rel_JSON_array["page_title"] = wfMsg("ur-remove-relationship-title-confirm", user_name_display($user_id_to, $user_name_to), $label);
			$rel_JSON_array["button_1_text"] = wfMsg("ur-main-page");
			$rel_JSON_array["button_1_link"] = "";
			$rel_JSON_array["button_2_text"] = wfMsg("ur-your-profile");
			$rel_JSON_array["button_2_link"] = "window.location='profile.html?user=".$wgUser->getName()."';";
		
			$rel_JSON_array["user_name"] = $user_name_to;
			$rel_JSON_array["rel_type"] = $relationship_type;
			
			$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
			$response = new AjaxResponse( $text );
			$response->setContentType( "application/javascript; charset=utf-8" ); 
			return $response;
			
		}
	}
}

$wgAjaxExportList [] = 'wfViewRelationshipRequestsJSON';
function wfViewRelationshipRequestsJSON($callback="viewRelRequests"){
	global $IP;
	
	$rel_JSON_array = wfdoViewRelationshipRequestsJSON(); 
	$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

function wfdoViewRelationshipRequestsJSON(){	
	global $wgUser, $wgOut, $wgTitle, $wgRequest, $IP, $wgMessageCache, $wgStyleVersion;
	
	if($wgUser->getID() == 0){

		$rel_JSON_array["rel"] = array();
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = "You must be logged in to view friend requests 
						    Click <a href=\"login.html\">here</a> to login
						    or click <a href=\"register.html\">here</a> to register.";
		
		return $rel_JSON_array;
	}

	$rel = new UserRelationship($wgUser->getName() );
	$friend_request_count = $rel->getOpenRequestCount($wgUser->getID(),1);
	$foe_request_count = $rel->getOpenRequestCount($wgUser->getID(),2);

	$output = "";
	$plural = "";
	
	$rel_JSON_array["page_title"] = wfMsg("ur-requests-title");
	$rel_JSON_array["status_message"] = "";
	$rel_JSON_array["type"] = "";
	
	$requests_full = array();
	
	$requests = $rel->getRequestList(0);
	
	if ($requests) {
		
		foreach ($requests as $request) {
			
			if ($request["type"]=="Foe") {
				$label = wfMsg("ur-foe");
			} else {
				$label = wfMsg("ur-friend");
			}
			
			$user_from =  Title::makeTitle(NS_USER,$request["user_name_from"]);
			
			$p = new ProfilePhoto( $request["user_id_from"] );
			 
			$request["avatar_img"] = $p->getProfileImageURL("l");
			
			$message = $wgOut->parse( trim($request["message"]), false );
			$request["text"] = wfMsg('ur-requests-message', "profile.html?user=".$request["user_name_from"], $request["user_name_from"], $label);
			$request["message"] = $message;
			$request["button_1_text"] = wfMsg("ur-accept");
			$request["button_1_link"] = "javascript:requestResponse(1,{$request["id"]});";
			$request["button_2_text"] = wfMsg("ur-reject");
			$request["button_2_link"] = "javascript:requestResponse(-1,{$request["id"]});";
			
			$requests_full[] = $request;
		}
		
	} else {
		
		$invite_link = "invite.html";
		$rel_JSON_array["status_message"] = wfMsg("ur-no-request-message", $invite_link);	
	}
	
	$rel_JSON_array["rel"] = $requests_full;
	
	return $rel_JSON_array;
}

function wfGetRelForNotificationJSON(){	
	global $wgUser, $wgOut, $wgTitle, $wgRequest, $IP, $wgMessageCache, $wgStyleVersion;
	
	if($wgUser->getID() == 0){
		return array();
	}
	
	$rel = new UserRelationship($wgUser->getName() );
	$friend_request_count = $rel->getOpenRequestCount($wgUser->getID(),1);
	
	$requests = $rel->getRequestList(0);
	
	$requests_full = array();
	
	if ($requests) {
		
		foreach ($requests as $request) {
			if ($request["type"]=="Foe") {
				$label = wfMsg("ur-foe");
			} else {
				$label = wfMsg("ur-friend");
			}
			$user_from =  Title::makeTitle(NS_USER,$request["user_name_from"]);
			
			$p = new ProfilePhoto( $request["user_id_from"] );
			 
			$request["avatar_img"] = $p->getProfileImageURL("l");
			$request["avatar_img_s"] = $p->getProfileImageURL("s");
			$request["user_name_display"] = user_name_display($request["user_id_from"], $request["user_name_from"]);
			
			$message = $wgOut->parse( trim($request["message"]), false );
			$request["text"] = wfMsg('ur-requests-message', "profile.html?user=".$request["user_name_from"], $request["user_name_display"], $label);
			$request["message"] = $message;
			$request["button_1_text"] = wfMsg("ur-accept");
			$request["button_1_link"] = "javascript:requestResponse(1,{$request["id"]});";
			$request["button_2_text"] = wfMsg("ur-reject");
			$request["button_2_link"] = "javascript:requestResponse(-1,{$request["id"]});";
			
			$requests_full[] = $request;
		}
		
	}
	return $requests_full;
}


$wgAjaxExportList [] = 'wfRelationshipRequestResponseJSON';
function wfRelationshipRequestResponseJSON($response, $request_id, $callback="handleReqResp",$trust_level){
	global $wgUser, $wgOut, $IP, $wgMessageCache; 
	$out = "";
	
	$rel_JSON_array = array();
	$rel_JSON_array["avatar_img"] = "";
	$rel_JSON_array["request_id"] = "";
	$rel_JSON_array["message"] = "";

	
	$rel = new UserRelationship($wgUser->getName() );
	if($rel->verifyRelationshipRequest($request_id) == true ){
		$request = $rel->getRequest($request_id);
		$user_name_from = $request[0]["user_name_from"];
		$user_id_from = User::idFromName($user_name_from);
		$rel_type = strtolower($request[0]["type"]);
		
		global $wgMemc;
		$key = wfMemcKey( 'user_relationship', 'awaitingrequests', $user_id_from );
		$wgMemc->delete( $key );
		
		$rel->updateRelationshipRequestStatus($request_id,$response);
	
		$p = new ProfilePhoto( $user_id_from );
	
		$rel_JSON_array["avatar_img"] = $p->getProfileImageURL("l");
		$rel_JSON_array["request_id"] = $request_id;
		$rel_JSON_array["user_name_from"] = $user_name_from;
		
		if($response==1){
			$rel->addRelationship($request_id,true, $trust_level);
			$rel_JSON_array["message"] = wfMsg("ur-requests-added-message", user_name_display($user_id_from, $user_name_from), $rel_type);
		}else {
			$rel_JSON_array["message"] = wfMsg("ur-requests-reject-message", user_name_display($user_id_from, $user_name_from), $rel_type);
		}
		
		$rel->deleteRequest($request_id);
	}
	
	$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'wfGetRelationshipJSON';
function wfGetRelationshipJSON($user_name="", $rel_type=1, $callback="handleEditRel"){
	
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgUserRelationshipDirectory; 
	
	$dbr =& wfGetDB( DB_SLAVE );
	
	$user_id_to = User::idFromName($user_name);

	if( $user_id_to > 0 ){
		$p = new ProfilePhoto( $user_id_to );
	
		$relationship_type = UserRelationship::getUserRelationshipByID($user_id_to,$wgUser->getID());
		
		$rel_JSON_array["avatar_img"] = $p->getProfileImageURL("l");
		$rel_JSON_array["rel_type"] = $relationship_type;
		$rel_JSON_array["user_name"] = $user_name;
		
	}else{
		$rel_JSON_array["rel"] = array();
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = "The specified user does not exist.";
				
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}
	
	if( $relationship_type  > 0 ){
		
		$s = $dbr->selectRow( '`user_relationship`', array('UNIX_TIMESTAMP(r_date) as timestamp', 'r_trust_type'), 
				/*where*/ array( 'r_user_id' => $wgUser->getID(), 'r_user_id_relation' => $user_id_to )  
					, __METHOD__
		);
		$rel_JSON_array["timestamp"] = $s->timestamp;
		$rel_JSON_array["trust_type"] = $s->r_trust_type;
		$rel_JSON_array["status_message"] = "You became friends " . get_time_ago($s->timestamp) . " ago" ;
		$rel_JSON_array["button_1_text"] = "Edit";
		$rel_JSON_array["button_1_link"] = "javascript:submit_rel_edit();";
		$rel_JSON_array["remove_rel_text"] = wfMsg("ur-remove-relationship", ucfirst( wfMsg("ur-friend") ));
		$rel_JSON_array["user_safe"] = urlencode($user_name);
				
	}else{
		
		if( UserRelationship::userHasRequestByID($user_id_to,$wgUser->getID()) == true) {	
			$rel_JSON_array["status_message"] = wfMsg("ur-add-error-message-pending-request", wfMsg("ur-friend"), user_name_display($user_id_to, $user_name_to));
		}else{
			$rel_JSON_array["status_message"] = "You are not friends with ".user_name_display($user_id_to, $user_name_to);
			$rel_JSON_array["button_1_text"] = "Add as Friend";
			$rel_JSON_array["button_1_link"] = "addrel.html?user={$user_name}";
		}
	}
	
	$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'wfEditRelationshipJSON';
function wfEditRelationshipJSON($user_name="", $trust_type=1, $callback="handle_edited"){
	
	global $wgUser, $wgOut, $IP, $wgMessageCache, $wgUserRelationshipDirectory; 
	
	$user_id_to = User::idFromName($user_name);
	if( $user_id_to > 0 ){
		
		$dbr =& wfGetDB( DB_MASTER );
		
		$dbr->update( '`user_relationship`',
			array( /* SET */
				'r_trust_type' => $trust_type
			), array( /* WHERE */
				'r_user_id' => $wgUser->getID(),
				'r_user_id_relation' => $user_id_to
			), __METHOD__
		);
		$dbr->commit();
	}
	
	$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'wfFriendsActivityJSON';
function wfFriendsActivityJSON($user_name="", $count = 25){
	global $wgUser, $wgOut, $wgRequest, $IP, $wgMessageCache, $wgMemc;
	$user_id = User::idFromName($user_name);
	
	if( $user_id > 0 ){
		
		$key = wfMemcKey( 'user', 'friendsactivity', $user_id );
		$wgMemc->delete($key);
		$data = $wgMemc->get( $key );
		$bulletin_tracker = array();
		$max_bulletins = array();
		$max_bulletins["wall"] = 2;
		$max_bulletins["basic profile"] = 1;
		$max_bulletins["personal profile"] = 1;
		$max_bulletins["work profile"] = 1;
		$max_bulletins["status"] = 1;
		
		if( !$data ){
			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT ub_id, ub_user_id, ub_user_name, ub_type, UNIX_TIMESTAMP(ub_date) as timestamp, ub_message FROM user_bulletin
			WHERE ub_user_id IN (select r_user_id from user_relationship where r_user_id_relation = {$user_id}) order by ub_id desc LIMIT 0," . $count*3;
		
			$res = $dbr->query($sql);
			$bulletins = array();
			while ($row = $dbr->fetchObject( $res ) ) {
				 $type_name = UserBulletin::$bulletin_types[ $row->ub_type ];
				
				 $bulletin_tracker[ $row->ub_user_id ][$type_name] = $bulletin_tracker[ $row->ub_user_id ][$type_name] + 1;
				 
				 if( $max_bulletins[$type_name] &&  $bulletin_tracker[ $row->ub_user_id ][$type_name] > $max_bulletins[$type_name] ){
					 continue;
				 }
				 
				 $user_name_display_m = "";
				 if( $row->ub_type == 1 || $row->ub_type == 3){
					$user_id_m = User::idFromName( $row->ub_message );
					$user_name_display_m = user_name_display( $user_id_m, $row->ub_message );
				 }
				 
				 $bulletins[] = array(
					 "id"=>$row->ub_id,"timestamp"=>($row->timestamp ) , "ago" => get_time_ago( $row->timestamp ),
					 "type"=>($row->ub_type ), "type_name" => $type_name,
					 "user_name_display"=> user_name_display( $row->ub_user_id, $row->ub_user_name),
					 "user_name" => $row->ub_user_name, "user_id" => $row->ub_user_id,
					 "message" => $row->ub_message,
					 "text" => UserBulletin::getBulletinText($type_name, $row->ub_message, $gender, $user_name_display_m)
				);
				
			}
			$bulletins = array_slice( $bulletins, 0, $count );
			$wgMemc->set($key, $bulletins, 60 * 5);
		}else{
			$bulletins = $data;
		}
		
		$profile_JSON_array["activity"] = array(
			"time" => time(),
			"user_name_display"=>user_name_display($id, $user_name),
			//"r_avatar"=>$rp->getProfileImageURL("l"),
			"title"=>"Friends Activity",
			"activity_items"=>$bulletins,
		);
	}
	
	$text = "var json_bulletins=" . jsonify($profile_JSON_array) . ";\n\nhome_from_JSON(json_bulletins);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}

$wgAjaxExportList [] = 'wfGetPeopleYouMayKnowJSON';
function wfGetPeopleYouMayKnowJSON($callback="showPeople"  ){
	
	global $wgUser, $wgOut, $wgRequest, $IP, $wgMessageCache, $wgMemc;
	
	$rel_JSON_array = array();
	$rel_JSON_array["r_user_name"] = "";
	
	if ($wgUser->isLoggedIn()) {
		$rel_JSON_array["r_user_name"] = $wgUser->getName();
	}
	
	$rel_JSON_array["error"] = 0;
	$rel_JSON_array["status_message"] = "";
				
	if($wgUser->getID() == 0){
		$rel_JSON_array["rel"] = array();
		$rel_JSON_array["error"] = 1;
		$rel_JSON_array["status_message"] = "You must login to see this page.";
		
		$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
		$response = new AjaxResponse( $text );
		$response->setContentType( "application/javascript; charset=utf-8" ); 
		return $response;
	}	
	
	//get your hide list
	$key = wfMemcKey( 'mayknow', 'hide', $wgUser->getID() );
	$data = $wgMemc->get( $key );
	if( !is_array( $data ) ){
		
		$dbr =& wfGetDB( DB_SLAVE );
		$res = $dbr->select( '`people_you_may_know_hide`', 
				array('hide_user_id'),
				array("user_id" => $wgUser->getID() ), __METHOD__, 
				""
		);
		$may_know_hide = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			$may_know_hide[] = $row->hide_user_id;
		}
		$wgMemc->set( $key, $may_know_hide );
	}else{
		$may_know_hide = $data;
	}
	
	//Get your 20 random friends
	$rel = new UserRelationship($wgUser->getName());
	//$friends = $rel->getRandomRelationships( 50 );
	$friends = $rel->getAllRelationships();
	
	//get your list of requests you sent and are pending
	$awaiting_requests = $rel->getAwaitingRequests();
	
	$all_friends = $rel->getAllRelationships();
	$all_friends[ $wgUser->getID() ] = array();
	
	$friends_full = array();
	$may_know_bucket = array();
	
	//Load all of each friends friends
	foreach( $friends as $friend ){
	
		$p = new ProfilePrivacy();
		$p->loadPrivacyForUser( $friend["user_name"] );
		
		if( $p->getPrivacyCheckForUser("VIEW_FULL") && $p->getPrivacyCheckForUser("VIEW_FRIENDS") ){
			$rel_of_friend = new UserRelationship( $friend["user_name"] );
			$complete_friends_of_friend = $rel_of_friend->getAllRelationships();
			$you_may_know =  array_diff_key($complete_friends_of_friend, $all_friends);
		
			foreach ($you_may_know as $friend) {
				
				if( in_array( $friend["user_id"] , $may_know_hide ) ) continue;
				
				$friend["awaiting_request"]= in_array( $friend["user_id"] , $awaiting_requests );
				
				if( !array_key_exists( $friend["user_id"], $may_know_bucket ) ){
					$user =  Title::makeTitle( NS_USER  , $friend["user_name"]  );
					$p = new ProfilePhoto( $friend["user_id"] );
					
					$friend["avatar"] = $p->getProfileImageURL("m");
					$friend["user_name_display"] = user_name_display($friend["user_id"], $friend["user_name"]);
					$friend["link"] = $user->escapeFullUrl();
					$friends_full[] = $friend;
					$may_know_bucket[$friend["user_id"]] = 1;
				}else{
					$may_know_bucket[$friend["user_id"]] = $may_know_bucket[$friend["user_id"]] + 1;
				}
			}
		}
	}
	//go through each person and set mutual count
	foreach( $friends_full as &$person ){
		$person["mutual_count"] = $may_know_bucket[ $person["user_id"] ];
	}
	
	usort($friends_full, "wfSortPeopleYouMayKnow");
	
	$count= 25;
	if( $count > count( $friends_full ) ){
		$count = count( $friends_full );
	}
	
	$you_may_know_randomized = array_slice( $friends_full, 0, $count, true );	
	
	$rel_JSON_array["count"] = count($you_may_know_randomized);
	$rel_JSON_array["rel"] = $you_may_know_randomized;
	$text = "var json_rel=" . jsonify($rel_JSON_array) . ";\n\n{$callback}(json_rel);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;

}

function wfSortPeopleYouMayKnow($x, $y){
	if ( $x["mutual_count"] > $y["mutual_count"] ){
		return -1;
	}else{
		return 1;
	}
}
	
$wgAjaxExportList [] = 'wfPeopleYouMayKnowHideJSON';
function wfPeopleYouMayKnowHideJSON($user_id = 0, $callback="handle_hide"){
	global $wgUser, $wgMemc;
	
	if ($wgUser->isLoggedIn()) {
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->insert( '`people_you_may_know_hide`',
		array(
			'user_id' => $wgUser->getID(),
			'hide_user_id' => $user_id
			),__METHOD__
		);	
		$dbr->commit();
		$key = wfMemcKey( 'mayknow', 'hide', $wgUser->getID() );
		$wgMemc->delete($key);
	}
	$text = "void(0);";
	$response = new AjaxResponse( $text );
	$response->setContentType( "application/javascript; charset=utf-8" ); 
	return $response;
}
?>
